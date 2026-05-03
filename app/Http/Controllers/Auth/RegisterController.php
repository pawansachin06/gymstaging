<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Service;
use App\Models\Currency;
use App\Models\Membership;
use App\Models\CheckoutSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Stripe\StripeClient;

class RegisterController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function checkout(Request $request)
    {
        $request->merge(['email' => Str::lower($request->input('email', ''))]);
        $data = $request->validate([
            'checkout_id' => ['nullable'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'string', 'max:100'],
            'service_id' => ['required', 'exists:services,id'],
            'membership_id' => ['required', 'exists:memberships,id'],
            'coupon_code' => ['nullable', 'string'],
            'newsletter' => ['nullable', 'boolean'],
            'currency_code' => ['required', 'exists:currencies,code'],
        ]);
        try {
            $membership = Membership::query()
                ->findOrFail($data['membership_id']);
            $promotionCodeId = null;
            $currencyCode = strtoupper($data['currency_code']);

            $stripe = new StripeClient(config('services.stripe.secret'));
            // validate coupon code
            $promo = null;
            if (!empty($data['coupon_code'])) {
                $promoCodes = $stripe->promotionCodes->all([
                    'code' => $data['coupon_code'],
                    'active' => true,
                    'limit' => 1,
                ]);
                if (empty($promoCodes->data)) {
                    return resJson('Invalid coupon', 422);
                }
                $promo = $promoCodes->data[0];
                $promotionCodeId = $promo->id;
            }

            // load or create checkout session
            $checkout = null;
            if (!empty($data['checkout_id'])) { // if id not empty, fetch
                $checkout = CheckoutSession::query()
                    ->find($data['checkout_id']);
            }
            if ($checkout && $checkout->email !== $data['email']) {
                // email changed -> reset everything
                $checkout = null;
            }
            if (empty($checkout)) { // if empty, try email
                $checkout = CheckoutSession::query()
                    ->where('email', $data['email'])->first();
            }
            if (empty($checkout)) { // if still empty, create new
                $checkout = CheckoutSession::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'type' => 'register',
                    'amount' => 0,
                    'status' => 'pending',
                    'currency_code' => $currencyCode,
                    'membership_id' => $membership->id,
                    'password' => bcrypt($data['password']),
                    'meta' => [],
                ]);
            }

            $meta = $checkout->meta ?? [];
            $meta['service_id'] = $data['service_id'] ?? '';
            $meta['newsletter'] = $data['newsletter'] ?? false;

            // load or create stripe customer
            if (!empty($checkout->stripe_customer_id)) {
                // update email if changed
                $stripe->customers->update(
                    $checkout->stripe_customer_id,
                    ['email' => $data['email'], 'name' => $data['name']]
                );
                $customerId = $checkout->stripe_customer_id;
            } else {
                // try to find existing Stripe customer
                $existing = $stripe->customers->search([
                    'query' => "email:'{$data['email']}'",
                ]);
                if (!empty($existing->data)) {
                    $customerId = $existing->data[0]->id;
                } else {
                    $customerId = $stripe->customers->create([
                        'email' => $data['email'],
                        'name' => $data['name']
                    ])->id;
                }
                $checkout->stripe_customer_id = $customerId;
            }

            // get all subscriptions for this customer
            $subscriptions = $stripe->subscriptions->all([
                'customer' => $customerId,
                'status' => 'all',
                'limit' => 100,
            ]);
            foreach ($subscriptions->data as $sub) {
                if (in_array($sub->status, ['incomplete', 'past_due', 'unpaid'])) {
                    // cancel immediately if not recent
                    if ($checkout->stripe_subscription_id != $sub->id) {
                        $stripe->subscriptions->cancel($sub->id, [
                            'invoice_now' => false,
                            'prorate' => false,
                        ]);
                    }
                }
            }

            // create or update subscription
            $priceId = $membership->stripe_price_ids[$currencyCode] ?? null;
            if (!$priceId) {
                throw new Exception('Currency not supported');
            }
            // get price from Stripe
            $price = $stripe->prices->retrieve($priceId);
            $amount = $price->unit_amount; // in cents
            $discountAmount = 0;

            // calculate discount for preview
            if ($promotionCodeId) {
                if ($promo->coupon->percent_off) {
                    $discountAmount = (int) round($amount * ($promo->coupon->percent_off / 100));
                } elseif ($promo->coupon->amount_off) {
                    // Stripe stores fixed discount per currency
                    if ($promo->coupon->currency === strtolower($currencyCode)) {
                        $discountAmount = min($promo->coupon->amount_off, $amount);
                    }
                } elseif (!empty($promo->coupon->currency_options)) {
                    $opt = $promo->coupon->currency_options[strtolower($currencyCode)] ?? null;
                    if ($opt && isset($opt->amount_off)) {
                        $discountAmount = min($opt->amount_off, $amount);
                    }
                }
            }
            $subtotal = $amount;
            $total = max(0, $amount - $discountAmount);

            $subscription = null;
            if ($checkout->stripe_subscription_id) {
                try {
                    $subscription = $stripe->subscriptions->retrieve(
                        $checkout->stripe_subscription_id
                    );
                    // get current subscription currency
                    $currentCurrency = strtoupper(
                        $subscription->items->data[0]->price->currency
                    );
                    if ($currentCurrency !== $currencyCode) {
                        // currency mismatch -> treat as new
                        $subscription = null;
                    }
                    // also treat invalid states as null
                    if ($subscription && in_array($subscription->status, [
                        'canceled', 'incomplete_expired',
                    ])) {
                        $subscription = null;
                    }
                } catch (Exception $e) {
                    $subscription = null;
                }
            }

            if (
                $checkout->stripe_subscription_id &&
                $subscription === null
            ) {
                try {
                    $stripe->subscriptions->cancel(
                        $checkout->stripe_subscription_id,
                        ['invoice_now' => false, 'prorate' => false]
                    );
                } catch (Exception $e) {
                    // ignore if already gone
                }
                $checkout->stripe_subscription_id = null;
            }

            $params = [
                'customer' => $checkout->stripe_customer_id,
                'items' => [
                    ['price' => $priceId],
                ],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'checkout_id' => $checkout->id
                ],
            ];

            if ($promotionCodeId) {
                $params['promotion_code'] = $promotionCodeId;
            }

            if (!$subscription) {
                // create new subscription (currency safe)
                $subscription = $stripe->subscriptions->create($params);
            
            } else {
                // update only if same currency
                $updateParams = [
                    'items' => [[
                        'id' => $subscription->items->data[0]->id,
                        'price' => $priceId,
                    ]],
                    'expand' => ['latest_invoice.payment_intent'],
                ];
                if ($promotionCodeId) {
                    $updateParams['promotion_code'] = $promotionCodeId;
                }
                $subscription = $stripe->subscriptions->update(
                    $subscription->id,
                    $updateParams
                );
            }

            // save changes
            $checkout->meta = $meta;
            $checkout->currency_code = $currencyCode;
            $checkout->membership_id = $membership->id;
            $checkout->stripe_subscription_id = $subscription->id;
            $checkout->save();

            $clientSecret = $subscription->latest_invoice->payment_intent->client_secret;
            if (!$clientSecret) {
                throw new Exception('Unable to initialize payment');
            }
            $redirectUrl = route('checkout-pending', [
                'checkout_id' => $checkout->id,
            ]);
            return response()->json([
                'checkout_id' => $checkout->id,
                'redirect_url' => $redirectUrl,
                'client_secret' => $clientSecret,
                'pricing' => [
                    'subtotal' => $subtotal / 100,
                    'discount' => $discountAmount / 100,
                    'total' => $total / 100,
                    'currency_code' => strtoupper($price->currency),
                ],
            ]);
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }

    public function joinService(Request $request, Service $service)
    {
        $user = $request->user();
        $action = $request->input('action');
        $isAjax = $request->boolean('ajax');
        if ($isAjax) {
            if ($action === 'register') {
                $input = $request->validate([
                    'name' => ['required', 'string', 'max:150'],
                    'email' => ['required', 'email', 'max:100', 'unique:users'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                    'newsletter' => ['nullable', 'boolean'],
                ]);
                return resJson('Select membership');
            }
            try {
                if ($action === 'get-currencies') {
                    $cols = 'id,name,code,rate';
                    $items = Currency::query()->select(explode(',', $cols))
                        ->orderBy('sequence')->get();
                    return resJson(['items' => $items]);
                } elseif ($action === 'get-memberships') {
                    $currencies = Currency::pluck('code')->toArray();
                    $stripe = new StripeClient(config('services.stripe.secret'));
                    $cols = 'id,name,excerpt,duration,features,stripe_price_ids';
                    $cols .= ',is_popular,overline,underline,sequence';
                    $items = Membership::query()
                        ->select(explode(',', $cols))
                        ->orderBy('sequence')
                        ->get()->map(function($item) use ($currencies, $stripe) {
                            $prices = [];
                            foreach ($currencies as $code) {
                                $priceId = $item->stripe_price_ids[$code] ?? null;
                                if (!$priceId) {
                                    continue;
                                }
                                $price = cache()->remember(
                                    "stripe_price_$priceId",
                                    3600,
                                    function() use ($stripe, $priceId) {
                                        return $stripe->prices->retrieve($priceId);
                                    }
                                );
                                $prices[$code] = $price->unit_amount / 100;
                            }
                            $item->loading = false;
                            $item->prices = $prices;
                            return $item;
                        });
                    return resJson(['items' => $items]);
                } elseif ($action = 'checkout') {
                    $membershipId = $request->input('membership_id');
                    if (empty($membershipId)) {
                        return resJson('Please select membership', 422);
                    }
                    $membership = Membership::query()
                        ->where('id', $membershipId)
                        ->first(['id', 'stripe_price_id']);
                    if (!$membership || empty($membership->stripe_price_id)) {
                        return resJson('Membership not found', 422);
                    }
                    $checkoutUrl = route('join.checkout');
                    $redirectUrl = route('checkout-pending');
                    return resJson([
                        'service_id' => $service->id,
                        'checkout_url' => $checkoutUrl,
                        'redirect_url' => $redirectUrl,
                    ]);
                }
                return resJson([]);
            } catch (Exception $e) {
                return resJson($e->getMessage(), 500, $e);
            }
        }
        $stripeKey = config('services.stripe.key');
        return view('auth.join-service', [
            'service' => $service,
            'stripeKey' => $stripeKey,
        ]);
    }

    public function join(Request $request)
    {
        $services = Service::query()
            ->whereNotNull('variant')
            ->get(['id', 'name', 'slug', 'type'])
            ->groupBy('type');
        $steps = [[
            'title' => 'Get Discovered',
            'icon' => 'icons.fa.magnifying-glass',
            'content' => 'Appear when people are actively searching for your business.',
        ], [
            'title' => 'Win Enquiries',
            'icon' => 'icons.fa.comment-dots',
            'content' => 'Turn traffic into direct enquiries with a clear, trusted listing.',
        ], [
            'title' => 'Member Perks',
            'icon' => 'icons.fa.gift',
            'content' => 'Access exclusive perks from trusted industry partners.',
        ], ];
        return view('auth.join', [
            'steps' => $steps,
            'services' => $services,
        ]);
    }

    public function register(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'newsletter' => ['nullable', 'boolean'],
        ]);
        try {
            return resJson('Testing', 422);
        } catch (Exception $e) {
            return resJson($e->getMessage(), 500, $e);
        }
    }
}
