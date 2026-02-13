<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @package App
 * @property string $title
*/
class ListingQualification extends Model
{  
    protected $fillable = ['name','listing_id'];
    
}
