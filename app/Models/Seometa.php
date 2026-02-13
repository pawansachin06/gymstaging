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
class Seometa extends Model
{
    use SoftDeletes;

    protected $fillable = ['page_url', 'title','description','keywords'];

}
