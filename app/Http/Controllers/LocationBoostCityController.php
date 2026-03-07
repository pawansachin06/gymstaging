<?php

namespace App\Http\Controllers;

use App\Models\LocationBoostCity;
use App\Services\GooglePlacesApi;
use Exception;
use Illuminate\Http\Request;

class LocationBoostCityController extends Controller
{

    public function index(Request $request)
    {
        $benefits = [
            [
                'icon' => 'https://placehold.co/64.png',
                'title' => 'Top 3 Featured',
                'content' => 'Appear at the top of search results for your selected postcode district',
            ],
            [
                'icon' => 'https://placehold.co/64.png',
                'title' => 'Location Expantion',
                'content' => 'Boost your local area or target nearby districts to attract more members.',
            ],
            [
                'icon' => 'https://placehold.co/64.png',
                'title' => 'Limited Spots',
                'content' => 'Each postcode district has only 3 Featured placements.',
            ],
        ];
        $faqs = [
            [
                'title' => 'How many featured spots are available?',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
            ],
            [
                'title' => 'What happens when users search larger locations?',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
            ],
            [
                'title' => 'Can I boost multiple areas?',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
            ],
            [
                'title' => 'Can I cancel anytime?',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec mollis rhoncus nibh a ultrices. Sed vel quam nunc. Phasellus a ipsum ante. Quisque magna dolor, imperdiet ac interdum id, gravida eget justo.',
            ],
        ];
        return view('location-boost-cities.index', [
            'faqs' => $faqs,
            'benefits' => $benefits,
        ]);
    }

    public function availableSlots(Request $request)
    {
        try {
            $placeId = $request->query('place-id', '');
            $placesApi = GooglePlacesApi::getInstance();
            $place = $placesApi->getPlaceDetails($placeId);
            if (empty($place['success'])) {
                return response()->json([
                    'place' => $place,
                    'message' => $place['message']
                ], 422);
            }

            if (empty($place['postcode']['code'])) {
                return response()->json([
                    'place' => $place,
                    'message' => 'This address do not have postal code',
                ], 422);
            }

            return response()->json([
                'slots' => [],
                'place' => $place,
                'message' => '',
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
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
