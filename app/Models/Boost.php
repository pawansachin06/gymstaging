<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
 */
class Boost extends Model
{
    protected $table = 'boosts';
    protected $fillable = ['listing_id', 'payment_id', 'user_id', 'brand'];
    protected $casts = ['brand' => 'array'];

    const PENDING = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    public static $statuses = [0 => 'Pending', 'Approved', 'Rejected'];
    public static $brandImg = ['F' => '/images/Facebook.png', 'G' => '/images/google.png'];


    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($q)
    {
        $q->where('status', self::PENDING);
    }

    public function getStatusInfoAttribute()
    {
        return @self::$statuses[$this->status] ?: 'Pending';
    }
}
