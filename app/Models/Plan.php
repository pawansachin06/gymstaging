<?php
namespace App\Models;

use App\Http\Helpers\StripeHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Business
 *
 * @package App
 * @property string $name
*/
class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = ['business_id','frequency', 'amount' , 'free_trial','offer_price', 'plan_id'];
    
    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'business_listing');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
    
    public static function businesses()
    {
        return static::pluck('name', 'id');
    }

    public function getPriceAttribute()
    {
        return $this->offer_price > 0 ? $this->offer_price : $this->amount;
    }
   
    public function getDisplayPriceAttribute(){
        return substr($this->amount, -3) == ".00" ? substr($this->amount, 0, -3) : $this->amount;
    }

    public function getDisplayOfferPriceAttribute(){
        return substr($this->offer_price, -3) == ".00" ? substr($this->offer_price, 0, -3) : $this->offer_price;
    }
}
