<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sponsors;
use Illuminate\Support\Facades\Gate;
use Auth;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('sponsors_create')) {
            return abort(401);
        }
        
        $sponsors = Sponsors::get();
        
        $s_flag = (!$sponsors->isEmpty()) ? 1 : 0;
        
        //echo "<pre>";print_r($s_flag);exit;
        if($s_flag == 0){
            return view('admin.sponsors.create');
        }else{
            $sponsor_1 = Sponsors::getSponsor('sponser-1');
            $sponsor_2 = Sponsors::getSponsor('sponser-2');
            $sponsor_3 = Sponsors::getSponsor('sponser-3');
            //echo "<pre>";print_r($sponsor_3);exit;
            return view('admin.sponsors.update', compact('sponsor_1','sponsor_2','sponsor_3'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
             'name_1'=>'required',
             'link_1'=>'required|url',
             'image_1'=>'required|image|mimes:png,jpeg,jpg',
             'name_2'=>'required',
             'link_2'=>'required|url',
             'image_2'=>'required|image|mimes:png,jpeg,jpg',
             'name_3'=>'required',
             'link_3'=>'required|url',
             'image_3'=>'required|image|mimes:png,jpeg,jpg'
        ]);
       $post = $request->all();
       $imageName1 = $request->image_1->hashName(); 
       $request->image_1->store('images/sponsors');
       $sponsor_1 = [
            'name' => $post['name_1'],
            'website_link' => $post['link_1'],
            'tag'  => $post['tag_1'],
            'logo' => $imageName1
       ];
       Sponsors::insert($sponsor_1);

       $imageName2 = $request->image_2->hashName(); 
       $request->image_2->store('images/sponsors');

       $sponsor_2 = [
            'name' => $post['name_2'],
            'website_link' => $post['link_2'],
            'tag'  => $post['tag_2'],
            'logo' => $imageName2
       ];
       Sponsors::insert($sponsor_2);

       $imageName3 = $request->image_3->hashName(); 
       $request->image_3->store('images/sponsors');

       $sponsor_3 = [
            'name' => $post['name_3'],
            'website_link' => $post['link_3'],
            'tag'  => $post['tag_3'],
            'logo' => $imageName3
       ];
       Sponsors::insert($sponsor_3);
       return redirect()->route('admin.sponsors.index');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
    public function updataData(Request $request){
        $this->validate($request,[
             'name_1' => 'required',
             'link_1' => 'required|url',
             'image_1'=> 'image|mimes:png,jpeg,jpg',
             'name_2' => 'required',
             'link_2' => 'required|url',
             'image_2'=> 'image|mimes:png,jpeg,jpg',
             'name_3' => 'required',
             'link_3' => 'required|url',
             'image_3'=> 'image|mimes:png,jpeg,jpg'
        ]);

       $post = $request->all();
       $imageName1 = $imageName2 = $imageName3 ='';
       $sponsor_data1 = Sponsors::getSponsor('sponser-1');
       $sponsor_data2 = Sponsors::getSponsor('sponser-2');
       $sponsor_data3 = Sponsors::getSponsor('sponser-3');

       //sponsor 1
       
        if($request->file('image_1')){
            $logo1 = storage_path('images/sponsors/'.$sponsor_data1->logo);
            if (file_exists($logo1)) {
                unlink($logo1);
            }
            $imageName1 = $request->image_1->hashName(); 
            $request->image_1->store('images/sponsors');
        }else{
            $imageName1 = $sponsor_data1->logo;
        }
        $sponsor_1 = [
            'name' => $post['name_1'],
            'website_link' => $post['link_1'],
            'tag'  => $post['tag_1'],
            'logo' => $imageName1
        ];
        Sponsors::updateData($sponsor_1,'sponser-1');
        //sponsor 2
        if($request->file('image_2')){
            $logo2 = storage_path('images/sponsors/'.$sponsor_data2->logo);
            if (file_exists($logo2)) {
                unlink($logo2);
            }
           $imageName2 = $request->image_2->hashName(); 
           $request->image_2->store('images/sponsors');
        }else{
            
            $imageName2 = $sponsor_data2->logo;
        }
        $sponsor_2 = [
            'name' => $post['name_2'],
            'website_link' => $post['link_2'],
            'tag'  => $post['tag_2'],
            'logo' => $imageName2
        ];
        Sponsors::updateData($sponsor_2,'sponser-2');
        //sponsor 3
        if($request->file('image_3')){
            $logo3 = storage_path('images/sponsors/'.$sponsor_data3->logo);
            if (file_exists($logo3)) {
                unlink($logo3);
            }
            $imageName3 = $request->image_3->hashName(); 
            $request->image_3->store('images/sponsors');
        }else{
            $imageName3 = $sponsor_data3->logo;
        }
        $sponsor_3 = [
            'name' => $post['name_3'],
            'website_link' => $post['link_3'],
            'tag'  => $post['tag_3'],
            'logo' => $imageName3
        ];
       Sponsors::updateData($sponsor_3,'sponser-3');
       return redirect()->route('admin.sponsors.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
