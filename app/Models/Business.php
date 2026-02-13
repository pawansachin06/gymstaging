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
class Business extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'label', 'icon'];
    const SEARCH_LABELS = [1 => 'Somewhere to train', 2 => 'Someone to train me', 3 => 'Someone to mend me'];
    const VIDEOS = [
        'gym' => 'https://player.vimeo.com/video/434447315?autoplay=0&color=38b0ba&title=0&byline=0&portrait=0',
        'coach' => 'https://player.vimeo.com/video/434450657?autoplay=0&color=38b0ba&title=0&byline=0&portrait=0',
        'physio' => 'https://player.vimeo.com/video/435165545?autoplay=0&color=38b0ba&title=0&byline=0&portrait=0'
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class);
    }
}
