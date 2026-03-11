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
        'amount',
        'currency_code',
        'place_id',
        'latitude',
        'longitude',
        'status',
        'stripe_subscription_item_id',
    ];

    protected $casts = [
        'amount' => 'float',
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
        if (!Schema::hasColumn($tableName, 'amount')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->decimal('amount')->nullable()->after('postcode');
                $table->string('currency_code', 5)->nullable()->after('amount');
            });
            $messages[] = "$tableName amount, currency_code added.";
        }
        if (!Schema::hasColumn($tableName, 'stripe_subscription_item_id')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('stripe_subscription_item_id')->nullable()->after('status');
            });
            $messages[] = "$tableName stripe_subscription_item_id added.";
        }
        return $messages;
    }
}
