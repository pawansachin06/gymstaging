<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
	use SoftDeletes;
    protected $table = 'products';

    public function productfaqs()
    {
        return $this->hasMany(Productfaqs::class, 'product_id');
    }
    public function productimages()
    {
        return $this->hasMany(Productimages::class, 'product_id');
    }
}
