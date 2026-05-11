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

    protected $fillable = ['name', 'job', 'file_path', 'user_id', 'listing_id'];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        if (!empty($this->file_path) && !empty($this->listing->folder)) {
            $folder = $this->listing->folder;
            $name = $this->file_path;
            return url("uploads/{$folder}/{$name}");
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
    
}
