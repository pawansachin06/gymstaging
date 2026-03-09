<?php

namespace App\Http\Controllers;

use App\Models\LocationBoostCity;
use App\Models\LocationBoostPrice;
use App\Services\GoogleMapsApi;
use App\Services\GooglePlacesApi;
use Exception;
use Illuminate\Http\Request;

class LocationBoostCityController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        $listing = $user->listing()->select(['id', 'marker_image'])->first();

        if ($request->ajax()) {
            $data = $this->getDrafts($user);
            $total = $data['total'];
            $items = $data['items'];
            return response()->json([
                'message' => '',
                'total' => $total,
                'items' => $items,
            ]);
        }

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
            'listing' => $listing,
            'benefits' => $benefits,
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
                            $places[] = $value;
                            $postcodes[] = $value['postcode']['code'];
                        }
                    }
                }
            }

            if (empty($places)) {
                return response()->json([
                    'message' => 'Address does not have postal code',
                ], 422);
            }

            $counts = LocationBoostCity::query()
                ->join('subscriptions', 'subscriptions.id', '=', 'location_boost_cities.subscription_id')
                ->whereIn('postcode', $postcodes)
                ->where('subscriptions.stripe_status', 'active')
                ->selectRaw('postcode, COUNT(*) as total')
                ->groupBy('postcode')
                ->pluck('total', 'postcode');

            $prices = LocationBoostPrice::query()
                ->whereIn('postcode', $postcodes)->pluck('amount', 'postcode');
            $defaultPrice = LocationBoostPrice::query()
                ->whereNull('postcode')->first(['amount']);

            $slots = [];
            foreach ($places as $place) {
                $postcode = $place['postcode']['code'];
                $address = str_replace(" {$postcode}", '', $place['address']);
                $taken = $counts[$postcode] ?? 0;
                $available = max(0, 3 - $taken);
                $disabled = !($taken < 3);

                $price = $prices[$postcode] ?? $defaultPrice->amount;

                $slots[] = [
                    'taken' => $taken,
                    'price' => $price,
                    'id' => $place['id'],
                    'address' => $address,
                    'postcode' => $postcode,
                    'disabled' => $disabled,
                    'city' => $place['city'],
                    'available' => $available,
                    'country' => $place['country'],
                    'latitude' => $place['latitude'],
                    'longitude' => $place['longitude'],
                ];
            }

            return response()->json([
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

            foreach ($drafts as $draft) {
                $placeId = $draft['place_id'];
                $postcode = $draft['postcode'];
                $city = is_string($draft['city']) ?
                    $draft['city'] : $draft['city']['name'] ?? '';
                $country = is_string($draft['country']) ?
                    $draft['country'] : $draft['country']['name'] ?? '';

                $exists = LocationBoostCity::query()
                    ->where('user_id', $userId)
                    ->where('postcode', $postcode)
                    ->where('status', 'draft')
                    ->first(['id']);
                if ($exists) {
                    $exists->update([
                        'city' => $city,
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
        $user->createOrGetStripeCustomer([
            'name' => $user->name,
            'address' => [
                'line1' => $user->address_line_1,
                'line2' => $user->address_line_2,
                'city' => $user->city,
                'postal_code' => $user->postal_code,
            ]
        ]);
        $draftIds = implode(',', $items->pluck('id')->toArray());
        $intent = $user->createPayment(
            $data['total'] * 100, [
                'payment_method_types' => ['card'],
                'metadata' => [
                    'user_id' => $user->id,
                    'draft_ids' => $draftIds,
                    'type' => 'location_boost',
                ]
            ],
        );
        $stripeKey = config('services.stripe.key');
        return view('location-boost-cities.checkout', [
            'total' => $total,
            'items' => $items,
            'stripeKey' => $stripeKey,
            'clientSecret' => $intent->client_secret,
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
            ->whereIn('postcode', $postcodes)->pluck('amount', 'postcode');
        $defaultPrice = LocationBoostPrice::query()
            ->whereNull('postcode')->value('amount');
        $items->each(function ($item) use ($prices, $defaultPrice, &$total) {
            $price = $prices[$item->postcode] ?? $defaultPrice;
            $total = $total + $price;
            $item->price = $price;
        });
        return ['items' => $items, 'total' => $total];
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LocationBoostCity $locationBoostCity)
    {
        //
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
    public function destroy(LocationBoostCity $locationBoostCity)
    {
        //
    }
}
