<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        'postcode',
        'place_id',
        'latitude',
        'longitude',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
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

    public static function createTable()
    {
        $messages = [];
        $tableName = 'location_boost_cities';

        if (!Schema::hasColumn($tableName, 'postcode')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('postcode', 16)->nullable()->after('city');
                $table->enum('status', ['draft', 'active', 'inactive'])->nullable()->after('longitude');
                $table->string('place_id')->nullable()->after('postcode');
            });
            $messages[] = "$tableName postcode, status, place_id added.";
        }

        return $messages;
    }
}
