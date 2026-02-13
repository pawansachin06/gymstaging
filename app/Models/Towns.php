<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Towns extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'country',
        'subCountry',
        'name',
        'lat',
        'lng',
    ];
}
