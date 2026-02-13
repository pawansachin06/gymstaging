<?php
namespace App\Models;

use App\Http\Helpers\StripeHelper;
use App\Models\Traits\StorageurlTrait;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hash;
use Laravel\Cashier\Billable;
use Lab404\Impersonate\Models\Impersonate;
use App\Events\UserRegistered;
use Artisan;

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
class Coupon extends Authenticatable
{
    use Notifiable, Billable, StorageurlTrait, Impersonate;

    const REGISTER_COUPON = 'B';
    const VERIFICATION_COUPON = 'V';

    protected $fillable = ['code', 'type', 'value', 'minprice', 'expires_at', 'max_redemptions','status','stripe_id', 'duration', 'monthly', 'yearly','description','redemptions'];

    public static $duarationOptions = ['once' => '1 Invoice', '3' => '3 Invoices','6' => '6 Invoices','12' => '12 Invoices', 'forever' => 'All Invoice'];
    public static $types = [1 => 'Percentange', 2 => 'Flat Amount'];

    protected static function boot()
    {
        parent::boot();

        self::saved(function ($model) {
            if($model->coupon_type =="B") {
                Artisan::call('sync:coupon', ['id' => $model->id]);
            }
        });
    }
    
    public function business()
    {
        return $this->belongsToMany('App\Models\Business', 'business_coupon');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public static function getCouponByCode($code, $business_id, $amount = 0, $frequency = '', $check_stripe = true)
    {
        $query = self::query()
            ->where('code', $code)
            ->where('status', 1)
            ->where('stripe_id', '!=', '')
            ->where(function ($q){
                $q->where('expires_at', '>=', Carbon::now()->toDateTimeString())->orWhereNull('expires_at');
            });

        if($frequency == 'monthly'){
            $query->where('monthly',  1);
        }

        if($frequency == 'yearly'){
            $query->where('yearly',  1);
        }

        if($amount){
            $query->where(function ($q) use ($amount){
                $q->where('minprice', '<=', $amount)->orWhereNull('minprice');
            });
        }

        $coupon = $query->whereHas('business', function ($q) use ($business_id){
            $q->where('id', $business_id);
        })->first();

        if($coupon && $check_stripe){
            $stripe_coupon = (new StripeHelper)->retrieveCoupon($coupon->stripe_id);

            if(!$stripe_coupon || !@$stripe_coupon->valid){
                $coupon = null;
            }
        }

        return $coupon;
    }

    public function calculateAmount($amount)
    {
        $calc_amount = $amount;

        if($this->type == 1){
            $calc_amount -= ($amount * ($this->value/100));
        }elseif ($this->type == 2){
            $calc_amount -= $this->value;
        }

        return round($calc_amount, 2);
    }

    public function noOfPayments()
    {
        if($this->duration == "repeating"){
            $no_of_payments = $this->duration_months;
        }else{
            if($this->duration == "once"){
                $no_of_payments = 'One';
            }else{
                $no_of_payments = 'All';
            }
        }
        return $no_of_payments;
    }

    public function offerValue()
    {
        if($this->type == 1){
            $offerValue = round($this->value).'%';
        }else{
            $offerValue = '$ '.$this->value;
        }
        return $offerValue;
    }
}
