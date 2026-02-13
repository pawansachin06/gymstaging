<?php
namespace App\Models;

use App\Models\Traits\StorageurlTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Business
 *
 * @package App
 * @property string $name
*/
class Amenity extends Model
{
    use SoftDeletes,StorageurlTrait;

    protected $fillable = ['name', 'business_id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
  
}
