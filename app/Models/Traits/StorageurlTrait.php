<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Artisan;

/**
 * Class Business
 *
 * @package App
 * @property string $name
 */
trait StorageurlTrait
{
    public function getUrl($prop): string
    {
        if (!$this->{$prop}) {
            return '';
        }

        try {
            return Storage::url($this->{$prop});
        } catch (\Exception $e) {
            return '';
        }
    }

    public function getThumbUrl($prop)
    {
        if (!$this->{$prop}) {
            return '';
        }

        if (Storage::exists("/thumb/{$this->{$prop}}")) {
            return Storage::url("/thumb/{$this->{$prop}}");
        } else if (Storage::exists("/{$this->{$prop}}")) {
            try {
                $thumb = Image::make(storage_path("/app/public/{$this->{$prop}}"));
                $thumb->fit(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path("/app/public/thumb/{$this->{$prop}}"));

                return Storage::url("/thumb/{$this->{$prop}}");
            } catch (\Exception $e) {
                return Storage::url("/{$this->{$prop}}");
            }
        }

        return '';
    }

    public function getAmentityUrl($prop)
    {
        $imageurl = $this->getUrl($prop);

        if (!$imageurl) {
            return '';
        }

        return preg_replace("~\/(?!.*\/)~", '/amenity_icons/', $imageurl);
    }

    public function getMarkerUrl($prop)
    {
        if (!$this->{$prop}) {
            return url('gymselect/images/bubble.png');
        }
        $fileInfo = pathinfo($this->{$prop});
        $markerPNG = "{$fileInfo['filename']}.png";
        if (Storage::exists("/markers/{$markerPNG}")) {
            return Storage::url("/markers/{$markerPNG}");
        } else if (Storage::exists("/{$this->{$prop}}")) {
            try {
                Artisan::call('image:marker', ['--file' => $this->{$prop}]);
                return Storage::url("/markers/{$markerPNG}");
            } catch (\Exception $e) {
                return url('gymselect/images/bubble.png');
            }
        }
        return url('gymselect/images/bubble.png');
    }

}
