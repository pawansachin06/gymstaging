<?php

namespace App\Models\Traits;

use Illuminate\Support\Collection;
use Stripe\Charge as StripeCharge;

trait ExtendBillable
{
    public function charges($parameters = [])
    {
        $charges = [];

        $parameters = array_merge(['limit' => 100], $parameters);

        $stripeCharges = StripeCharge::all(
            ['customer' => $this->stripeId()] + $parameters,
            $this->stripeOptions()
        );

        if (!is_null($stripeCharges)) {
            foreach ($stripeCharges->data as $charge) {
                if ($charge->paid) {
                    $charges[] = $charge;
                }
            }
        }
        return new Collection($charges);
    }
}
