<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products;
use App\Models\Productfaqs;
use App\Models\Productimages;
use App\Models\Couponproducts;
use App\Models\Couponproductrelation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Products::query();
        
        if (! Gate::allows('products_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('products_delete')) {
                return abort(401);
            }
            $query->onlyTrashed();
        }

        $products = $query->orderBy('id', 'DESC')->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('products_create')) {
            return abort(401);
        }
        return view('admin.products.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
             'name'=>'required',
             'price'=>'required|numeric|min:0.30',
             'image'=> 'required',
             // 'question.*'=> 'required',
             // 'answer.*'=> 'required',
             'description'=> 'required',
        ]);

        $product = new Products();
        $product->name        = $request['name'];
        $product->price       = $request['price'];
        $product->description = $request['description'];

        $product->save();
        $product_id = $product->id;
    
        if (!empty($request['question'])) {
            foreach($request['question'] as $key => $question) {
                if ($question != '' && $request['answer'][$key] != '') {
                    $faq_product[] = [
                        'product_id' => $product_id,
                        'question'   => $question,
                        'answer'     => $request['answer'][$key]
                    ];
                }
            }
            if (!empty($faq_product)) {
                Productfaqs::insert($faq_product);
            }
        }
        foreach ($request->file('image') as $image) {
            $name = $image->hashName();
            $image->store('images/products');
            $image_names[] = [
                'product_id' => $product_id,
                'image'   => $name
            ];
        }

        Productimages::insert($image_names);
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('products_view')) {
            return abort(401);
        }

        $products = Products::where('id',$id)->with(['productfaqs','productimages'])->first();
        
        return view('admin.products.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('products_edit')) {
            return abort(401);
        }
        
       $products = Products::where('id',$id)->with(['productfaqs','productimages'])->first();

        return view('admin.products.edit', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
             'name'=>'required',
             'price'=>'required|numeric|min:0.30',
             // 'question.*'=> 'required',
             // 'answer.*'=> 'required',
             'description'=> 'required',
        ]);

        if($request['remove_image_ids']){
            Productimages::whereIn('id', $request['remove_image_ids'])->delete();
        }

        $get_images = Productimages::where('product_id',$request['product_id'])->get();

        if($get_images->isEmpty() && !$request->file('image')){
            $this->validate($request,[
                'image'=> 'required',
            ]);
        }

        // echo "<pre>";print_r($request->all());exit;
        $product = Products::find($request['product_id']);
        $product->name        = $request['name'];
        $product->price       = $request['price'];
        $product->description = $request['description'];
        $product->save();
        $product_id = $product->id;

        Productfaqs::where('product_id', $request['product_id'])->delete();
        if (!empty($request['question'])) {
            foreach($request['question'] as $key => $question) {
                if ($question != '' && $request['answer'][$key] != '') {
                    $faq_product[] = [
                        'product_id' => $product_id,
                        'question'   => $question,
                        'answer'     => $request['answer'][$key]
                    ];
                }
            }
            if (!empty($faq_product)) {
                Productfaqs::insert($faq_product);
            }
        }

        
        if($request->file('image')){
            $image_names = [];
            foreach ($request->file('image') as $image) {
                $name = $image->hashName();
                $image->store('public/images/products');
                $image_names[] = [
                    'product_id' => $product_id,
                    'image'   => $name
                ];
            }

            Productimages::insert($image_names);
        }

        
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('products_delete')) {
            return abort(401);
        }
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index');
    }
    /**
     * Delete all selected Products at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('products_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Products::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
