<?php

namespace App\Http\Controllers\Webhook;

use App\Models\Invoice;
use App\Models\Subscription;
use Carbon\Carbon;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        // Handle The Event
        if ($payload['data']['object']) {
            $data = $payload['data']['object'];
            $subscription_id = Subscription::where("stripe_id", $data ['subscription'])->value('id');
            if ($subscription_id) {
                $invoice = new Invoice();
                $invoice->fill([
                    'subscription_id' => $subscription_id,
                    'date' => Carbon::createFromTimestamp($data['created'])->toDateTimeString(),
                    'amount' => $data['amount_paid'] / 100,
                    'stripe_invoice_id' => $data['id'],
                    'stripe_charge_id' => $data['charge'],
                    'meta' => json_encode($payload)
                ]);
                $invoice->save();
            }
        }
    }
}
