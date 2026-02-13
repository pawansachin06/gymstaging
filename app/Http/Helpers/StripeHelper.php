<?php

namespace App\Http\Helpers;


use Stripe\Coupon as StripeCoupon;
use Stripe\Plan as StripePlan;

class StripeHelper {

    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createCoupon($data)
    {
        $coupon = null;

        try{
            $coupon = StripeCoupon::create($data);
        }catch (\Exception $e){
            //
        }

        return $coupon;
    }

    public function updateCoupon($id, $data)
    {
        $coupon = null;

        try{
            $coupon = StripeCoupon::update($id, $data);
        }catch (\Exception $e){
            //
        }

        return $coupon;
    }

    public function retrieveCoupon($id)
    {
        $coupon = null;

        try{
            $coupon = StripeCoupon::retrieve($id);
        }catch (\Exception $e){
            //
        }

        return $coupon;
    }

    public function getAllPlans()
    {
        try{
            $result = [];
            $plans = StripePlan::all(['active'=>true]);
            if ($plans){
                foreach ($plans->autoPagingIterator() as $plan) {
                    try{
                        $result[] = $plan;
                    }catch (\Exception $e){ }
                }
            }
            return $result;
        }catch (\Exception $e){
            //
        }
        return [];
    }

    public function getPlan($id)
    {
        try{
            return StripePlan::retrieve($id);
        }catch (\Exception $e){
            //
        }
        return null;
    }

    private function getResData($res) {
        return $res->data;
    }
}
