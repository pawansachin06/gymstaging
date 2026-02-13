<?php

namespace App\Http\Helpers;

use Spatie\Geocoder\Geocoder;

class GeoCodeHelper
{
    public static function getAddressByLatAndLng($lat, $lng)
    {
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));

        return $geocoder->getAddressForCoordinates($lat , $lng);
    }

    public static function getCoordinatesForAddress($address)
    {
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        
        return $geocoder->getCoordinatesForAddress($address);
    }
}
