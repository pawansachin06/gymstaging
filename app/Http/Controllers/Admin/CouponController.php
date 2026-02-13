<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponsRequest;
use App\Http\Requests\Admin\UpdateCouponsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Auth;
use App\Models\ReportAbuse;

class CouponController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a coupon of Coupon.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if (! Gate::allows('coupon_access')) {
            return abort(401);
        }

        $coupons = Coupon::where('coupon_type', Coupon::REGISTER_COUPON)->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating new Coupon.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('coupon_create')) {
            return abort(401);
        }
        $businesses = \App\Models\Business::pluck('name', 'id');
        return view('admin.coupons.create' ,compact('businesses'));
    }

    /**
     * Store a newly created Coupon in storage.
     *
     * @param  \App\Http\Requests\StoreListsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponsRequest $request)
    {
        if (! Gate::allows('coupon_create')) {
            return abort(401);
        }
        $coupon = new Coupon();
        $coupon->fill($request->except(['_token','duration','business']));
        if($request->duration == 'once' || $request->duration == 'forever'){
            $coupon->duration = $request->duration;
        }else{
            $coupon->duration = 'repeating';
            $coupon->duration_months = $request->duration;
        }
        $coupon->coupon_type = Coupon::REGISTER_COUPON;
        $coupon->save();
        $coupon->business()->attach($request->business);
       
        return redirect()->route('admin.coupon.index');
    }


    /**
     * Show the form for editing Coupon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('coupon_edit')) {
            return abort(401);
        }
        
        $businesses = \App\Models\Business::pluck('name', 'id');
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', compact('coupon','businesses'));
    }

    /**
     * Update Coupon in storage.
     *
     * @param  \App\Http\Requests\UpdateListsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponsRequest $request, $id)
    {
        if (! Gate::allows('coupon_edit')) {
            return abort(401);
        }
        $coupon = Coupon::findOrFail($id);
        $coupon->fill([
            'code' => $request->code,
            'status' => $request->status,
            'monthly' => $request->monthly,
            'yearly' => $request->yearly,
            'description' => $request->description
        ]);
        $coupon->save();  
        $coupon->business()->sync($request->business);  

        return redirect()->route('admin.coupon.index');
    }
}
