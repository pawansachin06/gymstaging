<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\StorageurlTrait;


class Partner extends Model
{
    use StorageurlTrait;
    
    protected $table = 'partners';
    protected $fillable = ['name','logo','link', 'about_us'];
}
