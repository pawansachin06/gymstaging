<?php

namespace App\Http\Controllers\Webhook;

use App\Models\Invoice;
use App\Models\Payment;
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

    public function handlePaymentIntentCreated($payload)
    {
        Log::info('STRIPE.payment_intent.created', ['payload' => $payload]);
    }

    public function handlePaymentIntentSucceeded($payload)
    {
        Log::info('STRIPE.payment_intent.succeeded', ['payload' => $payload]);
        $intent = $payload['data']['object'] ?? null;
        if (!$intent) {
            return $this->successMethod();
        }
        $intentId = $intent['id'];
        $status = $intent['status'];
        $meta = ['payload' => $intent];
        $amount = $intent['amount'] / 100;
        $customerId = $intent['customer'];
        $currencyCode = $intent['currency'];
        $environment = $intent['livemode'] ? 'live' : 'sandbox';

        $type   = $intent['metadata']['type'] ?? null;
        $userId = $intent['metadata']['user_id'] ?? null;

        $payment = Payment::firstOrCreate(
            ['stripe_intent_id' => $intentId],
            [
                'type' => $type,
                'meta' => $meta,
                'amount' => $amount,
                'status' => $status,
                'user_id' => $userId,
                'environment' => $environment,
                'stripe_intent_id' => $intentId,
                'currency_code' => $currencyCode,
                'stripe_customer_id' => $customerId,
            ],
        );

        return $this->successMethod();
    }
}
