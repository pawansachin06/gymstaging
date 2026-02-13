<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Couponproducts extends Model
{
    //
    use SoftDeletes;
    protected $table = 'coupons_products';
    public static $types = ['Percentage' => 'Percentage', 'Flat' => 'Flat Amount'];
}
