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
class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'business_id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
  
}
