<?php

namespace App\Http\Controllers\Webhook;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Listing;
use App\Models\Subscription;
use App\Models\CheckoutSession;
use Carbon\Carbon;
use Stripe\StripeClient;
use Illuminate\Support\Facades\DB;
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
        Log::info('stripe.invoice.payment_succeeded', $payload);

        // method handleInvoicePaymentSucceeded does not exist.
        // parent::handleInvoicePaymentSucceeded($payload);

        $invoice = $payload['data']['object'] ?? null;
        if (!$invoice) {
            return $this->successMethod();
        }

        $stripeSubscriptionId = $invoice['subscription'] ?? null;
        if (!$stripeSubscriptionId) {
            return $this->successMethod();
        }

        $stripe = new StripeClient(config('services.stripe.secret'));
        // retrieve subscription with metadata
        $subscription = $stripe->subscriptions->retrieve(
            $stripeSubscriptionId
        );

        $checkoutId = $subscription->metadata->checkout_id ?? null;
        if ($checkoutId) { // handle registration
            $checkout = CheckoutSession::find($checkoutId);
            if (!$checkout) {
                return $this->successMethod();
            }

            // already processed
            if ($checkout->status === 'completed') {
                // return $this->successMethod();
            }

            DB::transaction(function () use (
                $invoice,
                $checkout,
                $stripeSubscriptionId
            ) {
                $status = 1;
                $membershipId = $checkout->membership_id;
                $serviceId = $checkout->meta['service_id'] ?? null;
                $newsletter = !empty($checkout->meta['newsletter']);

                if (!empty($serviceId)) {
                    $service = Service::query()
                        ->where('id', $serviceId)
                        ->first(['id', 'type']);
                    if ($service) {
                        $status = $service->type == 'organization' ? 2 : 1;
                    }
                }
                

                // create user if not exists
                $user = User::firstOrCreate(
                    ['email' => $checkout->email],
                    [
                        'status' => $status,
                        'business_id' => 1,
                        'name' => $checkout->name,
                        'membership_id' => $membershipId,
                        'password' => $checkout->password,
                        'currency_code' => $checkout->currency_code,
                        'stripe_id' => $checkout->stripe_customer_id,
                        'newsletter' => $newsletter ? 'active': null,
                    ]
                );

                $listing = Listing::query()
                    ->where('service_id', $serviceId)
                    ->where('user_id', $user->id)
                    ->first(['id']);
                if (!$listing) {
                    Listing::create([
                        'business_id' => 1,
                        'user_id' => $user->id,
                        'name' => $checkout->name,
                        'service_id' => $serviceId,
                        'folder' => site()->datePath('listings'),
                    ]);
                }

                // local subscription row
                Subscription::updateOrCreate(
                    ['stripe_id' => $stripeSubscriptionId],
                    [
                        'user_id' => $user->id,
                        'name' => 'register',
                        'type' => 'register',
                        'stripe_plan' => '',
                        'stripe_status' => 'active',
                        'stripe_price' => $invoice['lines']['data'][0]['price']['id'] ?? null,
                        'quantity' => 1,
                    ]
                );
                // mark checkout complete
                $checkout->status = 'completed';
                $checkout->user_id = $user->id;
                $checkout->save();
            });
            return $this->successMethod();
        }


        // Prevent duplicates
        if (Invoice::where('stripe_invoice_id', $invoice['id'])->exists()) {
            return $this->successMethod();
        }

        $subscription_id = Subscription::where('stripe_id', $stripeSubscriptionId)->value('id');
        if (!$subscription_id) {
            return $this->successMethod();
        }

        Invoice::create([
            'subscription_id' => $subscription_id,
            'date' => Carbon::createFromTimestamp($invoice['created'])->toDateTimeString(),
            'amount' => ($invoice['amount_paid'] ?? 0) / 100,
            'stripe_invoice_id' => $invoice['id'],
            'stripe_charge_id' => $invoice['charge'] ?? null,
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
        $payment->process();

        return $this->successMethod();
    }
}
