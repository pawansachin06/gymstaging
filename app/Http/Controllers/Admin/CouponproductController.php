<?php

namespace App\Http\Controllers\Admin;


use App\Models\Couponproducts;
use App\Models\Couponproductrelation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class CouponproductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Couponproducts::query();
        
        if (! Gate::allows('pcoupon_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('pcoupon_delete')) {
                return abort(401);
            }
            $query->onlyTrashed();
        }

        $coupons = $query->orderBy('id', 'DESC')->get();

        return view('admin.pcoupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('pcoupon_create')) {
            return abort(401);
        }
        
        $products = \App\Models\Products::pluck('name', 'id');
        
        //echo "<pre>";print_r($products);exit;
        return view('admin.pcoupon.create', compact('products'));

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
             'code'=>'required',
             'value'=> 'required',
             'maximum_redemptions'=> 'required',
             'product_id'=> 'required',
        ]);

        $coupon = new Couponproducts();
        $coupon->name = $request['name'];
        $coupon->code = $request['code'];
        $coupon->type = $request['type'];
        $coupon->value = $request['value'];
        $coupon->maximum_redemptions = $request['maximum_redemptions'];
        $coupon->status = $request['status'];

        $coupon->save();
        $coupon_id = $coupon->id;
        
        $coupon_product = [];

        foreach($request['product_id'] as $product_id) {
            $coupon_product[] = [
                'product_id' => $product_id,
                'coupon_id' => $coupon_id
            ];
        }
        
        Couponproductrelation::insert($coupon_product);
        return redirect()->route('admin.pcoupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('pcoupon_view')) {
            return abort(401);
        }

        $coupon_product = Couponproductrelation::where('coupon_id',$id)->pluck('product_id')->toArray();
        $coupon_data    = Couponproducts::findOrFail($id);

        $products = \App\Models\Products::whereIn('id', $coupon_product)->pluck('name')->toArray();
        
        return view('admin.pcoupon.show', compact('coupon_data','coupon_product','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('pcoupon_edit')) {
            return abort(401);
        }
        
        $products = \App\Models\Products::pluck('name', 'id');

        $coupon_product = Couponproductrelation::where('coupon_id',$id)->pluck('product_id')->toArray();

        $coupon_data    = Couponproducts::findOrFail($id);

        return view('admin.pcoupon.edit', compact('products', 'coupon_data','coupon_product'));
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
             'code'=>'required',
             'value'=> 'required',
             'maximum_redemptions'=> 'required',
             'product_id'=> 'required',
        ]);

        
        $coupon = Couponproducts::find($request['coupon_id']);
       
        $coupon->name  = $request['name'];
        $coupon->code  = $request['code'];
        $coupon->type  = $request['type'];
        $coupon->value = $request['value'];
        $coupon->maximum_redemptions = $request['maximum_redemptions'];
        $coupon->status = $request['status'];

        $coupon->save();
        $coupon_id = $coupon->id;
        if($request['change_product'] == 1){

            Couponproductrelation::where('coupon_id', $request['coupon_id'])->delete();

            $coupon_product = [];
            foreach($request['product_id'] as $product_id) {
                $coupon_product[] = [
                    'product_id' => $product_id,
                    'coupon_id'  => $request['coupon_id']
                ];
            }
            
            Couponproductrelation::insert($coupon_product);
        }
        return redirect()->route('admin.pcoupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('pcoupon_delete')) {
            return abort(401);
        }
        $coupon = Couponproducts::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.pcoupon.index');
    }

    /**
     * Delete all selected Coupons at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('pcoupon_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Couponproducts::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
