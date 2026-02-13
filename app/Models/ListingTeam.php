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
class ListingTeam extends Model
{
    use StorageurlTrait;
    protected $fillable = ['name', 'job', 'user_id', 'file_path','listing_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
    
}
