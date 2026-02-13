<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProductOrder extends Model
{
    protected $table = 'product_orders';
    public $timestamps = true;
    protected $guarded = [];
}
