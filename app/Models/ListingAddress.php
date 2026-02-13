<?php

namespace App\Models;

use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
 */
class ListingAddress extends Model
{
    protected $fillable = ['name', 'street', 'city', 'country', 'postcode', 'latitude', 'longitude', 'based_gym', 'listing_id', 'link_listing_id', 'sync_geo', 'sync_geo_failed'];
    const DEFAULT_LOCATION = 'London, UK';
    const DEFAULT_LATLNG = ['51.5073509', '-0.1277583'];
    const RADIUS_DEFAULT = 20;
    const RADIUS_LIST = ['5' => '5', '10' => '10', '15' => '15', '20' => '20', '50' => '50'];
    const MILES_VARIANT = 3959;

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            if ($model->exists) {
                $model->sync_geo = 1;
            }
        });
    }

    public function saveWithoutEvents(array $options=[])
    {
        return static::withoutEvents(function() use ($options) {
            return $this->save($options);
        });
    }

    public function scopeFilterByRequest($query, $keyword = self::DEFAULT_LOCATION, $radius)
    {
        list($latitude, $longtitude) = explode(',', AppHelper::getLatLong());

        $query->where('city', 'LIKE', "%{$keyword}%")
            ->orWhere('country', 'LIKE', "%{$keyword}%")
            ->orWhere('postcode', 'LIKE', "%{$keyword}%");

        $radiusSearch = (!$radius) ? self::RADIUS_DEFAULT : $radius;
        if ($latitude && $longtitude) {
            $query->orWhereRaw("ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( $latitude ) ) + COS( RADIANS( `latitude` )) * COS( RADIANS( $latitude )) * COS( RADIANS( `longitude` ) - RADIANS( $longtitude )) ) * " . self::MILES_VARIANT . " < " . $radiusSearch);
        }
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function linkedlisting()
    {
        return $this->belongsTo(Listing::class, 'link_listing_id');
    }

    public function getDistance($position)
    {
        list($latitude, $longtitude) = explode(',', $position);
        $theta = $longtitude - $this->longitude;
        $dist = sin(deg2rad($latitude)) * sin(deg2rad($this->latitude)) + cos(deg2rad($latitude)) * cos(deg2rad($this->latitude)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);

        return round($dist * 60 * 1.1515, 1);
    }
}
