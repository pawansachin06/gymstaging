<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Business
 *
 * @package App
 * @property string $name
*/
class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['subscription_id', 'date','amount','stripe_invoice_id','stripe_charge_id','meta'];
      
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    
}
