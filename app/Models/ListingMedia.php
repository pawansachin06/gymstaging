<?php
namespace App\Models;

use App\Models\Traits\StorageurlTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 *
 * @package App
 * @property string $title
*/
class ListingMedia extends Model
{
    use StorageurlTrait,SoftDeletes;

    protected $table = 'listing_medias';
    protected $fillable = ['file_path', 'listing_id'];

    public function list()
    {
        return $this->belongsTo(Listing::class);
    }
    
}
