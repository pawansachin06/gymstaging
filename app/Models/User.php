<?php

namespace App\Models;

use App\Models\Traits\ExtendBillable;
use App\Models\Traits\StorageurlTrait;
use App\Notifications\ResetPassword;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Cashier\Billable;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $remember_token
 */
class User extends Authenticatable
{
    use Notifiable, Billable, ExtendBillable, StorageurlTrait, Impersonate, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'remember_token', 'role_id', 'avatar', 'status', 'verify_token', 'address_line_1', 'address_line_2', 'city', 'postal_code'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const TYPE_PERSONAL = 'Personal';
    const TYPE_BUSINESS = 'Business';
    const TYPE_ADMIN = 'Admin';

    const ROLE_PERSONAL_USER = 1;
    const ROLE_BUSINESS_USER = 2;
    const ROLE_ADMIN = 3;

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->listing()->delete();
            $model->notifications()->delete();
            $model->reviews()->delete();
            $model->subscription()->delete();
        });

        self::saving(function ($model) {
            if ($model->role_id == self::ROLE_BUSINESS_USER && $listing = $model->listing) {
                $dispatcher = Listing::getEventDispatcher();
                Listing::unsetEventDispatcher();
                $listing->name = $model->name;
                $listing->save();
                if ($model->getOriginal('name')) {
                    DB::statement("UPDATE listing_reviews SET message = REPLACE(message, '&gt;{$model->getOriginal('name')}&lt;', '&gt;{$model->name}&lt;') WHERE INSTR(message, '&gt;{$model->getOriginal('name')}&lt;') > 0;");
                }
                Listing::setEventDispatcher($dispatcher);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setRoleIdAttribute($input)
    {
        $this->attributes['role_id'] = $input ? $input : null;
    }

    public function canImpersonate()
    {
        // return $this->is_admin == 1;
        return true;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function listing()
    {
        return $this->hasOne(Listing::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }

    public function reviews()
    {
        return $this->hasOne(ListingReview::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getIsAdminAttribute()
    {
        return $this->role_id == User::ROLE_ADMIN;
    }

    public function getProfileImageAttribute()
    {
        $profile_image = $this->getThumbUrl('avatar');

        if (!$profile_image && $this->listing) {
            $profile_image = @$this->listing->getThumbUrl('profile_image');
        }

        return $profile_image;
    }

    public function getValidStripeCustomerAttribute()
    {
        try {
            $stripResult = $this->asStripeCustomer();
            return !isset($stripResult->deleted);
        } catch (\Exception $e) { }

        return false;
    }
}
