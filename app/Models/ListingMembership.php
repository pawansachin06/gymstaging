<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
*/
class ListingMembership extends Model
{  
    protected $fillable = ['name','price','includes','listing_id'];
    public $timestamps = false;

    protected $casts = ['includes' => 'array'];
}
