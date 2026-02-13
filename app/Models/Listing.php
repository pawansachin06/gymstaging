<?php

namespace App\Models;

use App\Events\ListingCreated;
use App\Http\Helpers\AppHelper;
use App\Models\Traits\StorageurlTrait;
use Artisan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Class Listing
 *
 * @package App
 * @property string $name
 * @property string $city
 * @property string $address
 * @property text $description
 * @property string $logo
 */
class Listing extends Model
{
    use SoftDeletes, StorageurlTrait, HasSlug;

    protected $fillable = ['name', 'about', 'profile_image', 'cover_image', 'business_id', 'category_id', 'user_id', 'timetable', 'timetable_link', 'signup_url', 'timings', 'title', 'keyword', 'description', 'published', 'verified', 'coupon_id', 'ctas','boosted'];

    protected $casts = ['timings' => 'array', 'ctas' => 'object'];

    protected $perPage = 6;
    const CTA_LABEL = ['site' => 'Visit Site', 'enquire' => 'Enquire', 'call' => 'Call', 'email' => 'Email', 'whatsapp' => 'Whatsapp'];

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            if ($model->isDirty('profile_image')) {
                Artisan::call('image:marker', ['--file' => $model->profile_image]);
            }
            if ($model->isDirty('name')) {
                $dispatcher = User::getEventDispatcher();
                User::unsetEventDispatcher();
                $user = $model->user;
                $user->name = $model->name;
                $user->save();
                if ($model->getOriginal('name')) {
                    DB::statement("UPDATE listing_reviews SET message = REPLACE(message, '&gt;{$model->getOriginal('name')}&lt;', '&gt;{$model->name}&lt;') WHERE INSTR(message, '&gt;{$model->getOriginal('name')}&lt;') > 0;");
                }
                User::setEventDispatcher($dispatcher);
            }
        });

        self::created(function ($model) {
            event(new ListingCreated($model));
        });

        self::deleted(function ($model) {
            $model->links()->delete();
            $model->media()->delete();
            $model->address()->delete();
            $model->amentities()->delete();
            $model->memberships()->delete();
            $model->teams()->delete();
            $model->qualifications()->delete();
            $model->results()->delete();
            $model->reviews()->delete();
            $model->user()->delete();
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($q)
    {
        return $q->where('published', 1);
    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setCityIdAttribute($input)
    {

        $this->attributes['city_id'] = $input ? $input : null;
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }

    public function business()
    {
        return $this->belongsTo(Business::class)->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function links()
    {
        return $this->hasOne(ListingLink::class);
    }

    public function media()
    {
        return $this->hasMany(ListingMedia::class);
    }

    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

    public function boosts()
    {
        return $this->hasMany(Boost::class);
    }

    public function address()
    {
        return $this->hasOne(ListingAddress::class);
    }

    public function amentities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function memberships()
    {
        return $this->hasMany(ListingMembership::class)->where(function ($q) {
            $q->where('name', '<>', '')->orWhereNotNull('name');
        });
    }

    public function teams()
    {
        return $this->hasMany(ListingTeam::class);
    }

    public function qualifications()
    {
        return $this->hasMany(ListingQualification::class);
    }

    public function results()
    {
        return $this->hasMany(ListingResult::class);
    }

    public function reviews()
    {
    if(isset($this->filter_val))
    {
        if($this->filter_val=="All")
        {
            return $this->hasMany(ListingReview::class)->reply(false);
        }
        else if($this->filter_val=="Four&Five")
        {
            return $this->hasMany(ListingReview::class)->where("rating",">=","4")->reply(false);
        }
        else if($this->filter_val=="Five")
        {
            return $this->hasMany(ListingReview::class)->where("rating","5")->reply(false);
        }
        else
        return $this->hasMany(ListingReview::class)->reply(false);
    }
    else
          return $this->hasMany(ListingReview::class)->reply(false);
    }

    public function getFullAddressAttribute()
    {
        return $this->address ? $this->address->street . ',' . '' . $this->address->city . ',' . '' . $this->address->postcode : '';
    }

    public function getFeaturesLabelAttribute()
    {
        if ($this->business_id == '3') {
            return 'Treatments';
        } else if ($this->business_id == '2') {
            return 'Services';
        } else {
            return 'Features';
        }
    }

    public function scopeFilterByRequest($query, Request $request)
    {
        if ($request->input('city_id')) {
            $query->where('city_id', '=', $request->input('city_id'));
        }

        if ($request->input('business_id')) {
            $query->where('business_id', '=', $request->input('business_id'));
        }

        if ($request->input('category_id')) {
            $query->where('category_id', '=', $request->input('category_id'));
        }

        if ($request->input('search')) {
            $query->where('name', 'LIKE', '%' . $request->input('search') . '%');
        }

        return $query;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getReviewAverageAttribute()
    {
        return round($this->reviews->avg('rating'), 1);
    }

    public function getReviewStarsAttribute()
    {
        return AppHelper::getRatingStars($this->reviewAverage);
    }

    public function canReply()
    {
        return (auth()->user()->is_admin || (auth()->user()->id == $this->user_id));
    }

    public function getExternalUrl($prop)
    {
        $value = $this->{$prop};
        return (!preg_match("~^(?:f|ht)tps?://~i", $value)) ? "http://" . $value : $value;
    }

    public function getTimeTableUrlAttribute()
    {
        if ($this->timetable) {
            return $this->getUrl('timetable');
        }

        if ($this->timetable_link) {
            return $this->timetable_link;
        }

        return false;
    }

    public function scopePendingverify($query)
    {
        return $query->whereHas('verifications', function ($q) {
            $q->where('status', Verification::PENDING);
        });
    }

    public function scopePendingboost($query)
    {
        return $query->whereHas('boosts', function ($q) {
            $q->where('status', Boost::PENDING);
        });
    }

    public function getWebUrlAttribute()
    {
        $url = ltrim(route('listing.view', $this->slug), 'https://');
        if (!Str::startsWith($url, 'www.')) {
            $url = "www.{$url}";
        }

        return $url;
    }

    public function getCoverImageUrl()
    {

        $coverImage = $this->getUrl('cover_image');
        if ($coverImage == "") {
            $mediaImage = $this->media()->first();
            $coverImage = Storage::url($mediaImage->file_path);
        }
        return $coverImage;
    }

    public function getTimingsAttribute($value)
    {
        try {
            return array_filter(array_map(function ($v) {
                if (is_array($v)) {
                    return array_filter($v);
                }

                return $v;
            }, json_decode($value, true)));
        } catch (\Exception $e) {
            return [];
        }
    }

    public function ctaLink($key, $cta)
    {
        $value = @$cta->value;
        if ($key == 'call') {
            return "tel:{$value}";
        }
        if ($key == 'email') {
            return "mailto:{$value}";
        }
        if ($key == 'whatsapp') {
            return "https://wa.me/+{$cta->code}{$value}";
        }

        return $value;
    }
}
