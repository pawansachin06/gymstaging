<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{
    public static $accepted_type = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
    public $uploadPath;
    public $thumbPath;

    /**
     * File upload trait used in controllers to upload files
     */
    public function saveFiles(Request $request)
    {
        $this->uploadPath = storage_path('app/public');
        $this->thumbPath = storage_path('app/public') . "/thumb"; // upload path
        if (!file_exists($this->thumbPath)) {
            mkdir($this->thumbPath, 0775);
        }

        $finalRequest = $request->all();
        $this->uploadFiles($finalRequest, $request->allFiles());

        return new Request($finalRequest);
    }

    private function uploadFiles(&$finalRequest, $files = [], $dotNotation = null)
    {
        foreach ($files as $name => $data) {
            $fieldName = (is_null($dotNotation)) ? $name : "{$dotNotation}.{$name}";
            if (is_array($data)) {
                unset($files[$name]);
                $this->uploadFiles($finalRequest, $data, $fieldName);
            } else {
                $file = request()->file($fieldName);
                $filename = $this->makeFileName($file);

                if ($this->isImage($file)) {
                    if (!$this->saveImage($file, $filename)) {
                        $filename = null;
                    }
                } else {
                    $file->move($this->uploadPath, $filename);
                }

                data_set($finalRequest, $fieldName, $filename);
                unset($files[$name]);
            }
        }
    }

    private function makeFileName($file)
    {
        return time() . '-' . str_replace([" ", "(", ")"], ["_", "", ""], $file->getClientOriginalName());
    }

    private function isImage($file)
    {
        return in_array(strtolower($file->getClientOriginalExtension()), self::$accepted_type);
    }

    private function saveImage($file, $filename, $thumb = true)
    {
        try {
            $image = Image::make($file);
            if ($thumb) {
                $image->backup();
                $image->fit(200);
                $image->save("{$this->thumbPath}/{$filename}");
                $image->reset();
            }
            $image->resize(800, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save("{$this->uploadPath}/{$filename}");
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function dropzoneSave(Request $request)
    {
        try {
            $this->uploadPath = storage_path('app/public');
            $this->thumbPath = storage_path('app/public') . "/thumb"; // upload path

            $files = $request->file('file');
            $res = [];
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $image = Image::make($file);
                $image->backup();
                $image->fit(200);
                $image->save("{$this->thumbPath}/{$filename}");
                $image->reset();
                $image->resize(800, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })->save("{$this->uploadPath}/{$filename}");

                $res[] = [
                    'name' => url("storage/thumb/{$filename}"),
                    'original_name' => $filename,
                ];
            }

            return response()->json($res);
        } catch (\Exception $e) {
            return false;
        }
    }
}
