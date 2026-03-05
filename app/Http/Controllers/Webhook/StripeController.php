<?php

namespace App\Http\Controllers\Webhook;

use App\Models\Invoice;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
        Log::info("stripe-webhook", ['payload' => $payload]);

        parent::handleInvoicePaymentSucceeded($payload);

        $data = $payload['data']['object'] ?? null;
        if (!$data) {
            return $this->successMethod();
        }

        // Prevent duplicates
        if (Invoice::where('stripe_invoice_id', $data['id'])->exists()) {
            return $this->successMethod();
        }

        $stripeSubscriptionId = $data['subscription'] ?? null;
        if (!$stripeSubscriptionId) {
            return $this->successMethod();
        }

        $subscription_id = Subscription::where('stripe_id', $stripeSubscriptionId)->value('id');
        if (!$subscription_id) {
            return $this->successMethod();
        }
        
        Invoice::create([
            'subscription_id' => $subscription_id,
            'date' => Carbon::createFromTimestamp($data['created'])->toDateTimeString(),
            'amount' => ($data['amount_paid'] ?? 0) / 100,
            'stripe_invoice_id' => $data['id'],
            'stripe_charge_id' => $data['charge'] ?? null,
            'meta' => json_encode($payload),
        ]);

        return $this->successMethod();
    }
}
