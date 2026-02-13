<?php
namespace App\Models;

use App\Models\Traits\StorageurlTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
*/
class ListingResult extends Model
{   use StorageurlTrait;
    protected $table = 'listing_results';
    protected $fillable = ['file_path', 'listing_id'];
    
}
