<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
{
    protected $table = 'sponsors';
    public static function getSponsor($tag)
    {
        return Sponsors::where('tag',$tag)->first();
    }
    public static function updateData($data,$tag)
    {
    	Sponsors::where('tag', $tag)->update($data);
    }
}
