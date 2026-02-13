<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Business
 *
 * @package App
 * @property string $name
*/
class Subscription extends Model
{
  
   protected $fillable = ['user_id', 'name','stripe_id','stripe_plan','trial_ends_at','ends_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
      
    
}
