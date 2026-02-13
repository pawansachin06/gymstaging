<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Models\Coupon;
use App\Models\Setting;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VerificationCouponController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a coupon of Coupon.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Gate::allows('coupon_access')) {
            return abort(401);
        }

        $verificationcoupons = Coupon::where('coupon_type', Coupon::VERIFICATION_COUPON)->get();
        $toggleCoupon = [
            'gym' => Setting::getSetting('GYM_VERIFICATION_COUPON'),
            'coach' => Setting::getSetting('COACH_VERIFICATION_COUPON'),
            'physio' => Setting::getSetting('PHYSIO_VERIFICATION_COUPON'),
        ];

        return view('admin.verificationcoupons.index', compact('verificationcoupons','toggleCoupon'));
    }

    /**
     * Show the form for creating new Coupon.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('coupon_create')) {
            return abort(401);
        }

        $businesses = \App\Models\Business::pluck('name', 'id');
        return view('admin.verificationcoupons.create', compact('businesses'));
    }

    /**
     * Store a newly created Coupon in storage.
     *
     * @param \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('coupon_create')) {
            return abort(401);
        }
        $this->validate($request, [
            'code' => 'required',
            'value' => 'required',
        ]);

        $coupon = new Coupon();
        $coupon->fill($request->all());
        $coupon->coupon_type = Coupon::VERIFICATION_COUPON;
        $coupon->save();
        $coupon->business()->sync($request->business);

        return redirect()->route('admin.verificationcoupon.index');
    }


    /**
     * Show the form for editing Coupon.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('coupon_edit')) {
            return abort(401);
        }

        $businesses = \App\Models\Business::pluck('name', 'id');
        $coupon = Coupon::findOrFail($id);

        return view('admin.verificationcoupons.edit', compact('coupon', 'businesses'));
    }

    /**
     * Update Coupon in storage.
     *
     * @param \App\Http\Requests\UpdateListsRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Gate::allows('coupon_edit')) {
            return abort(401);
        }
        $coupon = Coupon::findOrFail($id);
        $coupon->fill($request->all());
        $coupon->save();
        $coupon->business()->sync($request->business);

        return redirect()->route('admin.verificationcoupon.index');
    }

    public function toggleCoupon(Request $request)
    {
        Setting::updateOrCreate(
            ['name' => strtoupper($request->field)],
            ['value' => (bool)$request->value]
        );
    }
}
