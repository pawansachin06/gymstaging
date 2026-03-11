<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\GoogleMapsApi;
use App\Services\GooglePlacesApi;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function googleMaps(Request $request)
    {
        try {
            $position = $request->input('position', '');
            list($latitude, $longitude) = explode(',', $position);

            if (!empty($latitude) && !empty($longitude)) {
                $mapsApi = GoogleMapsApi::getInstance();
                $placesData = $mapsApi->reverseGeocode($latitude, $longitude);

                if (empty($placesData['items'])) {
                    return response()->json([
                        'message' => 'Places not found',
                    ], 422);
                }

                $postcodes = collect($placesData['items'])
                    ->pluck('postcode.code')->filter()->values()->all();

                return response()->json([
                    'postcodes' => $postcodes,
                    'items' => $placesData['items'],
                ]);
            }
            return response()->json(['message' => 'lat, lng missing'], 422);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function googlePlaces(Request $request)
    {
        try {
            $placeId = $request->query('place-id', '');
            if (!empty($placeId)) {
                $placesApi = GooglePlacesApi::getInstance();
                $placeData = $placesApi->getPlaceDetails($placeId);
                if (empty($placeData['success'])) {
                    return response()->json([
                        'message' => $placeData['message']
                    ], 422);
                }
                return response()->json([
                    'item' => $placeData['item'],
                ]);
            }
            return response()->json(['message' => 'Place ID missing'], 422);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
