<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\StripeHelper;
use App\Http\Requests\Admin\StoreBusinessesRequest;
use App\Http\Requests\Admin\UpdateBusinessesRequest;
use App\Models\Business;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class BusinessesController extends Controller
{
    /**
     * Display a listing of Business.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('business_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (!Gate::allows('business_delete')) {
                return abort(401);
            }
            $businesses = Business::onlyTrashed()->get();
        } else {
            $businesses = Business::all();
        }

        return view('admin.businesses.index', compact('businesses'));
    }

    /**
     * Show the form for creating new Business.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('business_create')) {
            return abort(401);
        }
        return view('admin.businesses.create');
    }

    /**
     * Store a newly created Business in storage.
     *
     * @param \App\Http\Requests\StoreBusinessesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBusinessesRequest $request)
    {
        if (!Gate::allows('business_create')) {
            return abort(401);
        }
        $business = Business::create($request->all());


        return redirect()->route('admin.businesses.index');
    }


    /**
     * Show the form for editing Business.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('business_edit')) {
            return abort(401);
        }
        $business = Business::findOrFail($id);

        return view('admin.businesses.edit', compact('business'));
    }

    /**
     * Update Business in storage.
     *
     * @param \App\Http\Requests\UpdateBusinessesRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBusinessesRequest $request, $id)
    {
        if (!Gate::allows('business_edit')) {
            return abort(401);
        }
        $business = Business::findOrFail($id);
        $business->update($request->all());

        return redirect()->route('admin.businesses.index');
    }


    /**
     * Display Business.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('business_view')) {
            return abort(401);
        }

        $business = Business::findOrFail($id);
        $listings = $business->listings;

        return view('admin.businesses.show', compact('business', 'listings'));
    }


    /**
     * Remove Business from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('business_delete')) {
            return abort(401);
        }
        $business = Business::findOrFail($id);
        $business->delete();

        return redirect()->route('admin.businesses.index');
    }

    /**
     * Delete all selected Business at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('business_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Business::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Business from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('business_delete')) {
            return abort(401);
        }
        $business = Business::onlyTrashed()->findOrFail($id);
        $business->restore();

        return redirect()->route('admin.businesses.index');
    }

    /**
     * Permanently delete Business from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('business_delete')) {
            return abort(401);
        }
        $business = Business::onlyTrashed()->findOrFail($id);
        $business->forceDelete();

        return redirect()->route('admin.businesses.index');
    }

    public function planIndex(Request $request)
    {
        $businesses = Business::all();
        $stripePlans = $yearlyPlans = $monthlyPlans = [];
        $allPlans = (new StripeHelper)->getAllPlans();
        foreach ($allPlans as $plan) {
            $planName = "{$plan->nickname} / ".($plan->amount/100)." ".strtoupper($plan->currency);
            $stripePlans[$plan->id] = [
                'nickname' => $planName,
                'amount' => $plan->amount,
                'trial_period_days' => $plan->trial_period_days
            ];
            if ($plan['interval'] == 'month') {
                $monthlyPlans[$plan->id] = $planName;
            }
            if ($plan['interval'] == 'year') {
                $yearlyPlans[$plan->id] = $planName;
            }
        }
        Arr::sort($monthlyPlans);
        Arr::sort($yearlyPlans);

        $request->session()->put('stripe.plans', $stripePlans);

        return view('admin.businesses.plan', compact('businesses', 'yearlyPlans', 'monthlyPlans'));
    }

    public function storePlanManagement(Request $request)
    {
        $this->validate($request, [
            'plans.*.plan_id' => 'required',
        ], [
            'plans.0.plan_id.required' => 'Gym monthly plan must be selected',
            'plans.1.plan_id.required' => 'Gym yearly plan must be selected',
            'plans.2.plan_id.required' => 'Coach monthly plan must be selected',
            'plans.3.plan_id.required' => 'Coach yearly plan must be selected',
            'plans.4.plan_id.required' => 'Physio monthly plan must be selected',
            'plans.5.plan_id.required' => 'Physio yearly plan must be selected',
        ]);

        $plans = $request->plans;
        $stripePlans = $request->session()->pull('stripe.plans');
        foreach ($plans as $plan) {
            $amount = $stripePlans[$plan['plan_id']]['amount'] / 100;
            Plan::updateOrCreate(['business_id' => $plan['business_id'], 'frequency' => $plan['frequency']],
                [
                    'plan_id' => $plan['plan_id'],
                    'amount' => $amount,
                    'free_trial' => @$stripePlans[$plan['plan_id']]['trial_period_days'] ?: 0,
                    'offer_price' => '0'
                ]);
        }
        alert()->success('Plans updated successfully!!.');
        return redirect()->route('admin.businesses.plan_management');

    }

}
