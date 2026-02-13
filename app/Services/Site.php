<?php

namespace App\Services;

class Site
{
    const EARTH_RADIUS_KM = 6371; // Earth's radius in kilometers
    const EARTH_RADIUS_MI = 3959; // Earth's radius in miles

    /**
     * Calculate latitude and longitude bounds for a radius in kilometers or miles
     *
     * @param float $latitude Latitude of the center point
     * @param float $longitude Longitude of the center point
     * @param float $radius Radius for the search area
     * @param string $unit Unit of the radius ('km' for kilometers, 'mi' for miles)
     * @return array
     */
    public function getCoordinatesWithinRadius(float $latitude, float $longitude, float $radius = 100, string $unit = 'km')
    {
        // Determine Earth's radius based on the unit
        $earthRadius = $unit === 'mi' ? self::EARTH_RADIUS_MI : self::EARTH_RADIUS_KM;

        // Convert radius to radians
        $radiusInRadians = $radius / $earthRadius;

        // Latitude bounds
        $lat_min = $latitude - rad2deg($radiusInRadians);
        $lat_max = $latitude + rad2deg($radiusInRadians);

        // Longitude bounds (adjusted by latitude)
        $lng_min = $longitude - rad2deg($radiusInRadians / cos(deg2rad($latitude)));
        $lng_max = $longitude + rad2deg($radiusInRadians / cos(deg2rad($latitude)));

        return [
            'min' => ['lat' => $lat_min, 'lng' => $lng_min],
            'max' => ['lat' => $lat_max, 'lng' => $lng_max],
        ];
    }
}
