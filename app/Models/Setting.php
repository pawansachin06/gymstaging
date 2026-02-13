<?php

namespace App\Models;

use App\Helpers\SlimHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Setting extends Model
{
    use SoftDeletes;
    protected $fillable= ['name','value'];
    public static $allowFields = ['organization','stripe-gateway','invoice','mail','about-us','privacy_policy','terms_conditions','cookie_policy'];
    public static $imageFields = ['invoice' =>['logo']];

    public static $stripeCurrencies = ['aud' => 'AUD','usd'=> 'USD'];

    public static function slugToName($slug)
    {
        return strtoupper(str_replace('-','_',$slug));
    }

    public static function sanitizeValue($value = '')
    {
        if(is_array($value)){
            $slimImages = Arr::where($value, function ($value) {
                $array = json_decode($value);
                if (!is_null($array) && isset($array->output->image)) {
                    return $value;
                }
            });
            if ($slimImages) {
                foreach ($slimImages as $field => $fieldval) {
                    $value[$field] = SlimHelper::uploadImage("value.{$field}", "settings/");
                }
            }
            return json_encode($value);
        }

        return $value;
    }

    public function getValueAttribute($value)
    {
        $array = json_decode($value, true);
        if(!is_array($array)){
            return $value;
        }
        return $array;
    }


    public static function getSetting($name)
    {
        return @self::where('name', $name)->first()->value;
    }

    public function updateSetting($name, $value)
    {
        return self::where('name', $name)->update(['value'=>json_encode($value)]);
    }

    public function getAllSettings()
    {
        return self::all()->pluck('value','name');
    }

    public function setConfigSettings()
    {
        $settings = $this->getAllSettings();
        $timezone  = Arr::pull($settings,'ORGANIZATION.TIMEZONE','UTC');
        date_default_timezone_set($timezone);
        config()->set('app.timezone', $timezone);
        config()->set('app.tenant', $this->id);
        $settings = array_combine(
            array_map(function($k){ return 'settings.'.strtolower($k); }, array_keys($settings)),
            $settings
        );
        config()->set($settings);
    }
}
