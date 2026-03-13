<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\LocationBoostCity;
use App\Models\LocationBoostPrice;
use App\Models\Payment;
use App\Services\GoogleMapsApi;
use App\Services\GooglePlacesApi;
use Exception;
use Carbon\Carbon;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationBoostCityController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        $listing = $user->listing()->select([
            'id',
            'business_id',
            'marker_image',
        ])->first();

        if (!empty($request->input('ajax'))) {
            $businessId = $listing->business_id;
            $data = $this->getDrafts($user);
            $drafts = $data['items'];
            $total = $data['total'];

            $slots = LocationBoostCity::query()
                ->where('status', 'active')
                ->where('user_id', $user->id)
                ->get();

            return response()->json([
                'message' => '',
                'slots' => $slots,
                'total' => $total,
                'drafts' => $drafts,
                'business_id' => $businessId,
            ]);
        }

        $locations = LocationBoostCity::query()
            ->where('status', 'active')
            ->where('user_id', $user->id)
            ->pluck('id')->toArray();
        $mapId = config('services.google.maps.id');

        $boostedUserIds = LocationBoostCity::query()
            ->where('status', 'active')->pluck('user_id');
        $boostedListings = Listing::query()->has('user')
            ->with(['address', 'amentities'])->published()
            ->whereIn('user_id', $boostedUserIds)
            ->inRandomOrder()->limit(3)->get();
        $boostedListingsIds = $boostedListings->pluck('id');
        $organicListings = Listing::query()->has('user')
            ->with(['address', 'amentities'])->published()
            ->whereNotIn('id', $boostedListingsIds)
            ->inRandomOrder()->limit(3)->get();

        $benefits = [[
            'icon' => 'https://placehold.co/64.png',
            'title' => 'Top 3 Featured',
            'content' => 'Appear at the top of search results for your selected postcode district',
        ], [
            'icon' => 'https://placehold.co/64.png',
            'title' => 'Location Expantion',
            'content' => 'Boost your local area or target nearby districts to attract more members.',
        ], [
            'icon' => 'https://placehold.co/64.png',
            'title' => 'Limited Spots',
            'content' => 'Each postcode district has only 3 Featured placements.',
        ]];
        $faqs = [[
            'title' => 'How many featured spots are available?',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
        ], [
            'title' => 'What happens when users search larger locations?',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
        ], [
            'title' => 'Can I boost multiple areas?',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
        ], [
            'title' => 'Can I cancel anytime?',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
        ]];
        return view('location-boost-cities.index', [
            'faqs' => $faqs,
            'mapId' => $mapId,
            'listing' => $listing,
            'benefits' => $benefits,
            'locations' => $locations,
            'boostedListings' => $boostedListings,
            'organicListings' => $organicListings,
        ]);
    }

    public function availableSlots(Request $request)
    {
        try {
            $placeId = $request->query('place-id', '');
            $placesApi = GooglePlacesApi::getInstance();
            $placeData = $placesApi->getPlaceDetails($placeId);
            if (empty($placeData['success'])) {
                return response()->json([
                    'data' => $placeData,
                    'message' => $placeData['message']
                ], 422);
            }
            $place = $placeData['item'];
            $places = [$place]; // array of places
            $postcodes = [$place['postcode']['code']];

            $isFull = strpos($place['postcode']['code'], ' ') >= 2;
            if ($isFull) {
                return response()->json([
                    'message' => 'Address is not of district',
                ], 422);
            }

            if (empty($place['postcode']['code'])) {
                $latitude = $place['latitude'];
                $longitude = $place['longitude'];
                if (empty($latitude) || empty($longitude)) {
                    return response()->json([
                        'data' => $places,
                        'message' => 'This address do not have postal code',
                    ], 422);
                }
                // try reverse geocode
                $mapsApi = GoogleMapsApi::getInstance();
                $placesData = $mapsApi->reverseGeocode($latitude, $longitude);
                if (empty($placesData['items'])) {
                    return response()->json([
                        'data' => $placesData,
                        'message' => 'Address do not have areas with postal code',
                    ], 422);
                }
                $places = [];
                $postcodes = [];
                foreach ($placesData['items'] as $value) {
                    if (!empty($value['postcode']['code'])) {
                        if (!in_array($value['postcode']['code'], $postcodes)) {
                            $isFull = strpos($value['postcode']['code'], ' ') >= 2;
                            if ($isFull) {
                                // full postcodes are not used, only districts
                            } else {
                                $places[] = $value;
                                $postcodes[] = $value['postcode']['code'];
                            }
                        }
                    }
                }
            }

            if (empty($places)) {
                return response()->json([
                    'message' => 'Address does not have postal code',
                ], 422);
            }

            $user = $request->user();

            $counts = LocationBoostCity::query()
                ->where('status', 'active')
                ->whereIn('postcode', $postcodes)
                ->selectRaw('postcode, COUNT(*) as total')
                ->groupBy('postcode')
                ->pluck('total', 'postcode');
            $takenLocations = LocationBoostCity::query()
                ->where('status', 'active')
                ->where('user_id', $user->id)
                ->pluck('postcode')->toArray();

            $prices = LocationBoostPrice::query()
                ->whereIn('postcode', $postcodes)->pluck('amount', 'postcode');
            $defaultPrice = LocationBoostPrice::query()
                ->whereNull('postcode')->first(['amount']);

            $slots = [];
            foreach ($places as $place) {
                $postcode = $place['postcode']['code'];
                $city = $place['city']['code'] ?? '';
                if (empty($city) && !empty($place['postal_town']['code'])) {
                    $city = $place['postal_town']['code'];
                }

                $address = str_replace(" {$postcode}", '', $place['address']);
                $taken = $counts[$postcode] ?? 0;
                $available = max(0, 3 - $taken);
                $disabled = !($taken < 3);

                $amount = $prices[$postcode] ?? $defaultPrice->amount;
                if (in_array($postcode, $takenLocations)) {
                    $disabled = true;
                }

                $slots[] = [
                    'taken' => $taken,
                    'amount' => $amount,
                    'id' => $place['id'],
                    'city' => $city,
                    'address' => $address,
                    'postcode' => $postcode,
                    'disabled' => $disabled,
                    'available' => $available,
                    'total' => 3,
                    'country' => $place['country'],
                    'latitude' => $place['latitude'],
                    'longitude' => $place['longitude'],
                ];
            }

            return response()->json([
                'zoom' => 13,
                'slots' => $slots,
                'data' => $places,
                'message' => '',
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function removeDrafts(Request $request)
    {
        try {
            $user = $request->user();
            $id = $request->input('id');
            $item = LocationBoostCity::query()
                ->where('user_id', $user->id)
                ->where('status', 'draft')
                ->where('id', $id)
                ->first(['id']);
            if (!$item) {
                return response()->json([
                    'message' => 'Removed slot successfully'
                ]);
            }
            $item->forceDelete();
            return response()->json(['message' => 'Removed slot successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function addDrafts(Request $request)
    {
        $drafts = $request->input('drafts');
        try {
            if (empty($drafts) || !is_array($drafts)) {
                return response()->json([
                    'message' => 'Please select slots',
                ], 422);
            }

            $user = $request->user();
            $userId = $user->id;

            $postcodes = collect($drafts)->pluck('postcode')->filter()->unique();
            $prices = LocationBoostPrice::query()
                ->whereIn('postcode', $postcodes)->pluck('amount', 'postcode');
            $defaultPrice = LocationBoostPrice::query()
                ->whereNull('postcode')->value('amount');

            foreach ($drafts as $draft) {
                $placeId = $draft['place_id'];
                $postcode = $draft['postcode'];
                $city = is_string($draft['city']) ?
                    $draft['city'] : $draft['city']['name'] ?? '';
                $country = is_string($draft['country']) ?
                    $draft['country'] : $draft['country']['name'] ?? '';

                $amount = $prices[$postcode] ?? $defaultPrice;

                $exists = LocationBoostCity::query()
                    ->where('user_id', $userId)
                    ->where('postcode', $postcode)
                    ->where('status', 'draft')
                    ->first(['id']);
                if ($exists) {
                    $exists->update([
                        'city' => $city,
                        'amount' => $amount,
                        'country' => $country,
                        'place_id' => $placeId,
                        'latitude' => $draft['latitude'],
                        'longitude' => $draft['longitude'],
                    ]);
                } else {
                    LocationBoostCity::create([
                        'city' => $city,
                        'status' => 'draft',
                        'user_id' => $userId,
                        'amount' => $amount,
                        'country' => $country,
                        'subscription_id' => 0,
                        'place_id' => $placeId,
                        'postcode' => $postcode,
                        'latitude' => $draft['latitude'],
                        'longitude' => $draft['longitude'],
                    ]);
                }
            }

            $redirect = route('location-boost-cities.checkout');
            return response()->json([
                'redirect' => $redirect,
                'message' => 'Loading checkout...'
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        $user = $request->user();
        $data = $this->getDrafts($user);
        $total = $data['total'];
        $items = $data['items'];

        if (empty($total)) {
            return redirect()->route('location-boost-cities.index');
        }

        try {
            $user->createOrGetStripeCustomer([
                'name' => $user->name,
                'address' => [
                    'line1' => $user->address_line_1,
                    'line2' => $user->address_line_2,
                    'city' => $user->city,
                    'postal_code' => $user->postal_code,
                ]
            ]);
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        if ($request->input('ajax')) {
            $paymentMethodId = $request->input('id');
            if (empty($paymentMethodId)) {
                return response()->json([
                    'message' => 'Payment method id missing',
                ], 422);
            }

            $apiSecret = config('services.stripe.secret');
            $stripe = new StripeClient(['api_key' => $apiSecret]);

            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $user->stripe_id]
            );
            $stripe->customers->update(
                $user->stripe_id,
                [
                    'invoice_settings' => [
                        'default_payment_method' => $paymentMethodId
                    ]
                ]
            );

            DB::transaction(function () use ($stripe, $user, $items, $paymentMethodId) {
                $itemsPayload = [];
                $items = $items->values()->sortBy('id');
                $grouped = $items->groupBy('stripe_price_id');
                foreach ($grouped as $priceId => $slots) {
                    $itemsPayload[] = [
                        'price' => $priceId,
                        'quantity' => $slots->count(),
                        'metadata' => [
                            'slot_id' => $slots->pluck('id')->join(','),
                            'postcode' => $slots->pluck('postcode')->join(','),
                        ],
                    ];
                }
                $stripeSubscription = $stripe->subscriptions->create([
                    'items' => $itemsPayload,
                    'customer' => $user->stripe_id,
                    'default_payment_method' => $paymentMethodId,
                    'metadata' => [
                        'user_id' => $user->id,
                        'type' => 'location_boost',
                    ],
                ]);
                $currentPeriodEnd = $stripeSubscription->current_period_end;
                $ends_at = $currentPeriodEnd
                    ? Carbon::createFromTimestamp($currentPeriodEnd)
                    : null;
                $subscription = $user->subscriptions()->create([
                    'type' => 'location_boost',
                    'stripe_id' => $stripeSubscription->id,
                    'stripe_status' => $stripeSubscription->status,
                    'stripe_price' => null, // since multiple prices
                    'quantity' => 0,
                    'trial_ends_at' => null,
                    'ends_at' => $ends_at,
                ]);
                $stripeItems = collect($stripeSubscription->items->data)->keyBy('price.id');

                foreach ($grouped as $priceId => $slots) {
                    $stripeItem = $stripeItems[$priceId] ?? null;
                    if (!$stripeItem) continue;
                    foreach ($slots as $slot) {
                        unset($slot->stripe_price_id, $slot->stripe_product_id);
                        $slot->update([
                            'status' => 'active',
                            'currency_code' => 'gbp',
                            'subscription_id' => $subscription->id,
                            'stripe_subscription_item_id' => $stripeItem->id,
                        ]);
                    }
                }
            });

            return response()->json([
                'message' => 'Redirecting...',
                'redirect' => route('location-boost-cities.index'),
            ]);
        }

        $stripeKey = config('services.stripe.key');
        return view('location-boost-cities.checkout', [
            'items' => $items,
            'total' => $total,
            'total' => $total,
            'email' => $user->email,
            'stripeKey' => $stripeKey,
        ]);
    }

    private function getDrafts($user)
    {
        $total = 0;
        $userId = $user->id;
        $items = LocationBoostCity::query()
            ->where('user_id', $userId)
            ->where('status', 'draft')
            ->get();
        $postcodes = $items->pluck('postcode')->filter()->unique();
        $prices = LocationBoostPrice::query()
            ->whereIn('postcode', $postcodes)->get()->keyBy('postcode');
        $defaultPrice = LocationBoostPrice::query()
            ->whereNull('postcode')->first();
        $items->each(function ($item) use ($prices, $defaultPrice, &$total) {
            $priceRow = $prices[$item->postcode] ?? $defaultPrice;
            $amount = $priceRow->amount;
            $total = $total + $amount;
            $item->amount = $amount;
            $item->stripe_price_id = $priceRow->stripe_price_id;
            $item->stripe_product_id = $priceRow->stripe_product_id;
        });
        return ['items' => $items, 'total' => $total];
    }

    public function confirm(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent');
        if (empty($paymentIntentId)) {
            abort(500, 'Payment Intent Missing');
        }
        $payment = Payment::query()
            ->where('stripe_intent_id', $paymentIntentId)
            ->first(['id', 'processed_at']);
        if (!empty($payment->processed_at)) {
            return redirect()->route('location-boost-cities.index');
        }
        return view('location-boost-cities.confirm');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function validateSlots(Request $request)
    {
        try {
            $user = $request->user();

            $drafts = LocationBoostCity::query()
                ->where('user_id', $user->id)
                ->where('status', 'draft')
                ->get();

            if ($drafts->isEmpty()) {
                return response()->json([
                    'message' => 'No slots found in cart'
                ], 422);
            }

            $postcodes = $drafts->pluck('postcode')->unique()->values();

            $counts = LocationBoostCity::query()
                ->where('status', 'active')
                ->whereIn('postcode', $postcodes)
                ->selectRaw('postcode, COUNT(*) as total')
                ->groupBy('postcode')
                ->pluck('total', 'postcode');

            $removed = [];

            foreach ($drafts as $draft) {
                $taken = $counts[$draft->postcode] ?? 0;
                if ($taken >= 3) {
                    $removed[] = $draft->postcode;
                    $draft->status = 'conflict';
                    $draft->save();
                    $draft->delete(); // soft delete
                }
            }
            if (!empty($removed)) {
                $postcode = $removed[0];
                return response()->json([
                    'message' => "Postcode {$postcode} has just been taken.",
                    'postcodes' => $removed,
                ], 422);
            }
            return response()->json([
                'message' => 'Slots available'
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, LocationBoostCity $locationBoostCity)
    {
        if ($request->input('ajax')) {
            $subscription_id = $locationBoostCity->subscription_id;
            $subscription = Subscription::find($subscription_id);
            $message = 'After this date the featured spot will become available to other listings. ';
            $message .= 'Once slots are taken, you may not be able to secure this placement again.';
            if (!empty($locationBoostCity->ends_at)) {
                $message = 'Subscription already cancelled.';
            }
            return response()->json([
                'canceled' => !empty($locationBoostCity->ends_at),
                'ends_at' => optional($subscription->ends_at)->toIso8601String(),
                'item' => $locationBoostCity,
                'message' => $message,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LocationBoostCity $locationBoostCity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LocationBoostCity $locationBoostCity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, LocationBoostCity $locationBoostCity)
    {
        try {
            $user = $request->user();
            if ($user->id != $locationBoostCity->user_id) {
                return response()->json([
                    'message' => 'Slot not owned',
                ], 422);
            }
            if (!empty($locationBoostCity->ends_at)) {
                return response()->json([
                    'message' => 'Already cancelled',
                ], 422);
            }

            $subscription_id = $locationBoostCity->subscription_id;
            $subscription = Subscription::find($subscription_id);

            $apiSecret = config('services.stripe.secret');
            $stripe = new StripeClient(['api_key' => $apiSecret]);

            $stripeItemId = $locationBoostCity->stripe_subscription_item_id;
            $stripeItem = $stripe->subscriptionItems->retrieve($stripeItemId);
            if ($stripeItem->quantity > 1) {
                $stripe->subscriptionItems->update($stripeItemId, [
                    'quantity' => $stripeItem->quantity - 1,
                    'proration_behavior' => 'none'
                ]);
            } else {
                $stripe->subscriptions->update($subscription->stripe_id, [
                    'cancel_at_period_end' => true
                ]);
            }

            $locationBoostCity->update([
                'ends_at' => $subscription->ends_at,
            ]);
            return response()->json(['message' => 'Subscription cancelled']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
