<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleMapsApi
{
    private static $instance;

    private const CACHE_DIR = 'google-maps';
    private const CACHE_EXPIRY_MINUTES = 14 * 24 * 60; // 2 week in minutes

    public static function getInstance(): GoogleMapsApi
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function getKey()
    {
        return config('services.google.maps.key');
    }

    public function reverseGeocode(float $lat, float $lng): array
    {
        $dir = self::CACHE_DIR;
        $filename = round($lat, 3) . '_' . round($lng, 3);
        $cacheKey =  "$dir/$filename.json";

        if (Storage::disk('public')->exists($cacheKey)) {
            $lastModified = Storage::disk('public')->lastModified($cacheKey);
            $ageSeconds = time() - $lastModified;

            if ($ageSeconds < self::CACHE_EXPIRY_MINUTES * 60) {
                Log::info('GoogleMapsApi: Cache hit', [
                    'lat' => $lat,
                    'lng' => $lng,
                ]);

                $cached = json_decode(
                    Storage::disk('public')->get($cacheKey),
                    true
                );

                return [
                    // 'raw' => $cached,
                    'success' => true,
                    'source' => 'cache',
                    'items' => $this->formatGeocodeData($cached),
                ];
            }
        }

        try {
            $apiKey = $this->getKey();
            $url = 'https://maps.googleapis.com/maps/api/geocode/json';
            $response = Http::get($url, [
                'latlng' => "{$lat},{$lng}",
                'key' => $apiKey,
            ]);

            $data = $response->json();

            if (!$response->successful() || ($data['status'] ?? null) !== 'OK') {
                Log::error('GoogleMapsApi: API failed', [
                    'lat' => $lat,
                    'lng' => $lng,
                    'response' => $data,
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to reverse geocode location',
                    'details' => $data,
                ];
            }

            // Cache response
            Storage::disk('public')->put($cacheKey, json_encode($data));

            return [
                // 'raw' => $data,
                'success' => true,
                'source' => 'api',
                'items' => $this->formatGeocodeData($data),
            ];
        } catch (Exception $e) {
            Log::error('GoogleMapsApi: Exception', [
                'lat' => $lat,
                'lng' => $lng,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    private function formatGeocodeData(array $data)
    {
        $results = $data['results'] ?? [];
        if (empty($results)) {
            return [];
        }

        $items = [];
        foreach ($results as $result) {
            $components = $result['address_components'] ?? [];
            $address = $result['formatted_address']
                ?? $result['plus_code']['compound_code']
                ?? '';
            $location = ['latitude' => 0, 'longitude' => 0];
            if (!empty($result['geometry']['location'])) {
                $location = [
                    'latitude' => $result['geometry']['location']['lat'],
                    'longitude' => $result['geometry']['location']['lng'],
                ];
            }

            $city = ['code' => '', 'name' => ''];
            $state = ['code' => '', 'name' => ''];
            $country = ['code' => '', 'name' => ''];
            $postcode = ['code' => '', 'name' => ''];

            foreach ($components as $component) {
                $types = $component['types'] ?? [];
                $shortText = $component['short_name'] ?? '';
                $longText = $component['long_name'] ?? '';

                if (in_array('locality', $types)) {
                    $city['code'] = $shortText;
                    $city['name'] = $longText;
                }
                if (in_array('country', $types)) {
                    $country['code'] = $shortText;
                    $country['name'] = $longText;
                }
                if (in_array('postal_code', $types)) {
                    $postcode['code'] = $shortText;
                    $postcode['name'] = $longText;
                }
                if (in_array('administrative_area_level_1', $types)) {
                    $state['code'] = $shortText;
                    $state['name'] = $longText;
                }
            }
            $items[] = [
                'id' => $result['place_id'],
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'postcode' => $postcode,
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
                'place' => $result,
            ];
        }
        return $items;
    }
}
