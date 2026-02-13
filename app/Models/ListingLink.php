<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Listing
 *
 * @package App
 * @property string $name
 * @property string $city
 * @property string $address
 * @property text $description
 * @property string $logo
 */
class ListingLink extends Model
{
    use SoftDeletes;

    protected $fillable = ['email', 'phone', 'website', 'facebook', 'twitter', 'instagram', 'youtube', 'whatsapp_code', 'whatsapp', 'linkedin', 'listing_id'];


    public function getUrl($prop)
    {
        $value = $this->{$prop};
        return (!preg_match("~^(?:f|ht)tps?://~i", $value)) ? "http://" . $value : $value;
    }

    public function whatsappUrl()
    {
        return "https://wa.me/+{$this->whatsapp_code}{$this->whatsapp}";
    }
}
