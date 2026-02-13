<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;

use Illuminate\Http\Request;

class PartnerController extends Controller
{    
    use FileUploadTrait;

    public function index()
    {
        $partners = Partner::query()->get();

        return view('admin.partner.index',compact('partners'));
    }

    public function create()
    {
        return view('admin.partner.create');
    }

    public function store(Request $request)
    {
        $request = $this->saveFiles($request);

        $partner = new Partner();
        $partner->fill([
            'name' => $request->name,
            'link' => $request->link,
            'logo' => $request->logo,
            'about_us' => $request->about_us,
        ]);

        $partner->save();
        
        return redirect()->route('admin.partner.index');
    }

    public function edit($id)
    {
        $partner = Partner::find($id);

        $thumb = $partner->getThumbUrl('logo');
        if (!$thumb) {
            $thumb = url('/gymselect/images/user-img.jpg');
        }

        return view('admin.partner.edit',compact('partner','thumb'));

    }

    public function update(Request $request , $id)
    {
        $request = $this->saveFiles($request);
        
        $partner = Partner::find($id);

        $partner->fill([
            'name' => $request->name,
            'link' => $request->link,
            'about_us' => $request->about_us,
        ]);
        if($request->logo)
        {
            $partner->fill([
                'logo' => $request->logo,
            ]);
        }

        $partner->save();
        
        return redirect()->route('admin.partner.index');

    }

    public function show($id)
    {
        $partner = Partner::find($id);

        $thumb = $partner->getThumbUrl('logo');
        if (!$thumb) {
            $thumb = url('/gymselect/images/user-img.jpg');
        }

        return view('admin.partner.show',compact('partner','thumb'));
    }

    public function destroy($id)
    {
        $partner = Partner::find($id);
        $partner->delete();

        return redirect()->route('admin.partner.index');
    }
}
