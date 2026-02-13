<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Helpers\AppHelper;

class LocationBoostCity extends Model
{
    use SoftDeletes;

    const MILES_VARIANT = 3959;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'country',
        'city',
        'latitude',
        'longitude'
    ];

    public function scopeFilterByRequest($query, $radius)
    {
        list($latitude, $longtitude) = explode(',', AppHelper::getLatLong());

        $radiusSearch = $radius;
        if ($latitude && $longtitude) {
            $query->orWhereRaw("ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` )) * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longtitude )) ) * " . self::MILES_VARIANT . " < " . $radiusSearch);

            // $query->orWhereRaw("
            //     ACOS(
            //         LEAST(
            //             GREATEST(
            //                 SIN(RADIANS(`latitude`)) * SIN(RADIANS($latitude)) +
            //                 COS(RADIANS(`latitude`)) * COS(RADIANS($latitude)) *
            //                 COS(RADIANS(`longitude`) - RADIANS($longtitude)),
            //                 -1
            //             ),
            //             1
            //         )
            //     ) * " . self::MILES_VARIANT . " < " . $radiusSearch
            // );
        }
    }
}
