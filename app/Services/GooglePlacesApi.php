<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GooglePlacesApi
{
    private static $instance;

    private const CACHE_DIR = 'google-places';
    private const CACHE_EXPIRY_MINUTES = 14 * 24 * 60; // 2 week in minutes

    private function getKey()
    {
        return config('services.google.maps.key');
    }

    public static function getInstance(): GooglePlacesApi
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getSuggestions($payload = [])
    {
        $apiKey = $this->getKey();
        $input = $payload['input'] ?? '';
        $token = $payload['token'] ?? '';
        if (empty($input)) {
            return [];
        }
        $url = 'https://places.googleapis.com/v1/places:autocomplete';
        try {
            $fields = [
                'suggestions.placePrediction.placeId',
                'suggestions.placePrediction.text',
            ];
            $fieldsString = implode(',', $fields);
            $response = Http::withHeaders([
                'X-Goog-Api-Key' => $apiKey,
                'X-Goog-FieldMask' => $fieldsString,
                'Content-Type' => 'application/json',
            ])->post($url, [
                'input' => $input,
                'sessionToken' => $token,
            ]);
            $data = $response->json();
            // clean response
            $items = collect($data['suggestions'] ?? [])->map(function ($s) {
                $p = $s['placePrediction'];
                return [
                    'uid' => $p['placeId'] ?? null,
                    'text'    => $p['text']['text'] ?? null,
                ];
            })->values();
            return ['items' => $items];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getPlaceDetails($placeId = '')
    {
        if (empty($placeId)) {
            return [
                'success' => false,
                'message' => 'Place Id empty',
            ];
        }
        $cacheFileName = self::CACHE_DIR . '/' . $placeId . '.json';

        // check if data is in cache and still valid
        if (Storage::disk('public')->exists($cacheFileName)) {
            $lastModified = Storage::disk('public')->lastModified($cacheFileName);
            $cacheAgeSeconds = time() - $lastModified;
            $cacheExpirySeconds = self::CACHE_EXPIRY_MINUTES * 60;

            if ($cacheAgeSeconds < $cacheExpirySeconds) {
                // cache hit and not expired, return cached data
                Log::info("GooglePlacesApi: Cache hit for Place ID: {$placeId}", [
                    'cacheAgeSeconds' => $cacheAgeSeconds,
                    'cacheExpirySeconds' => $cacheExpirySeconds,
                ]);
                $cachedData = json_decode(Storage::disk('public')->get($cacheFileName), true);
                return [
                    'success' => true,
                    'item' => $this->formatPlaceData($cachedData), // Format cached data
                    'place' => $cachedData, // Return raw cached data too
                    'source' => 'cache', // Indicate data came from cache
                ];
            } else {
                Log::info("GooglePlacesApi: Cache expired for Place ID: {$placeId}");
                // cache exists but is expired, will proceed to make real request
            }
        }

        Log::info("GooglePlacesApi: No cache found for Place ID: {$placeId}");
        $apiKey = $this->getKey();
        $fields = [
            'location.latitude', // Access nested fields
            'location.longitude',
            'addressComponents',
        ];
        $fieldsString = implode(',', $fields);
        $url = "https://places.googleapis.com/v1/places/{$placeId}";
        try {
            $response = Http::withHeaders([
                'X-Goog-Api-Key' => $apiKey,
                'X-Goog-FieldMask' => $fieldsString, // Use field mask here
                'Content-Type' => 'application/json',
            ])->get($url, []);
            $placeData = $response->json();
            if ($response->successful()) {
                // cache the successful response
                Storage::disk('public')->put($cacheFileName, json_encode($placeData));
                return [
                    'success' => true,
                    'item' => $this->formatPlaceData($placeData),
                    'place' => $placeData,
                    'source' => 'api', // Indicate data came from API
                ];
            } else {
                Log::error('GooglePlacesApi: API call failed', [
                    'placeId' => $placeId,
                    'response' => $placeData,
                ]);
                return [
                    'success' => false,
                    'details' => $placeData, // Include Google's error response for debugging
                    'message' => 'Failed to fetch place details from Google API.',
                ];
            }
        } catch (Exception $e) {
            Log::error('GooglePlacesApi: Server error during API call', [
                'placeId' => $placeId,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    /**
     * Helper method to format the place data from Google API response.
     * This keeps the formatting logic separate and reusable for both cached and fresh data.
     */
    private function formatPlaceData(array $placeData): array
    {
        $location = $placeData['location'] ?? ['latitude' => 0, 'longitude' => 0];
        $addressComponents = $placeData['addressComponents'] ?? [];
        // $formattedAddress = $placeData['formattedAddress'] ?? '';

        $city = ['code' => '', 'name' => ''];
        $country = ['code' => '', 'name' => ''];
        $postcode = ['code' => '', 'name' => ''];

        foreach ($addressComponents as $component) {
            $types = $component['types'] ?? [];
            $shortText = $component['shortText'] ?? '';
            $longText = $component['longText'] ?? '';

            if (in_array('locality', $types)) {
                $city['code'] = $shortText;
                $city['name'] = $longText;
            } elseif (in_array('country', $types)) {
                $country['code'] = $shortText;
                $country['name'] = $longText;
            } elseif (in_array('postal_code', $types)) {
                $postcode['code'] = $shortText;
                $postcode['name'] = $longText;
            }
        }

        return [
            // 'formatted_address' => $formattedAddress,
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'city' => $city,
            'country' => $country,
            'postcode' => $postcode,
        ];
    }
}
