<?php

namespace App\Models;

use App\Events\ReviewCreated;
use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
 */
class ListingReview extends Model
{
    protected $fillable = ['user_id', 'user_name', 'listing_id', 'title', 'message', 'rating', 'review_id', 'brand'];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            if(!auth()->user()->isAdmin) {
                event(new ReviewCreated($model));
            }
        });

        self::deleted(function ($model) {
            $model->report()->delete();
        });
    }

    public function scopeReply($query, $boolean = true)
    {
        $condition = $boolean ? 'whereNotNull' : 'whereNull';
        return $query->{$condition}('review_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->belongsTo(self::class);
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'review_id');
    }

    public function getReviewStarsAttribute()
    {
        return AppHelper::getRatingStars($this->rating);
    }

    public function getIsReplyAttribute()
    {
        return !is_null($this->review_id);
    }

    public function report()
    {
        return $this->hasMany(ReportAbuse::class, 'table_id');
    }

    public function canReply()
    {
        return (auth()->user()->is_admin || (auth()->user()->id == $this->user_id));
    }
}
