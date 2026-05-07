<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;
use function is_string;
use function strlen;

class SiteService
{
    public function datePath($prefix = '', $suffix = '')
    {
        $date = now()->format('Y/m-d');
        $path = "$prefix/$date";
        if (!empty($suffix)) {
            $path .= "/$suffix";
        }
        return $path;
    }

    public function generateFilename($file, $prefix = '')
    {
        if (is_string($file)) {
            // Case: File URL is given
            $extension = pathinfo(parse_url($file, PHP_URL_PATH), PATHINFO_EXTENSION);
            $original_name = pathinfo(parse_url($file, PHP_URL_PATH), PATHINFO_FILENAME);
        } else {
            // Case: Uploaded file instance
            $extension = $file->getClientOriginalExtension();
            $original_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        }

        $original_name = Str::slug($original_name) ?: 'unnamed'; // Ensure fallback if slug is empty
        if (empty($prefix)) {
            $prefix = date('Y-m-d');
        }
        $prefix = Str::slug($prefix);
        $uid = Str::ulid()->toString(); // ULID is always 26 characters

        // Adjust max length by subtracting 3 (2 for dashes, 1 for the dot before the extension)
        $max_length = 100 - strlen($prefix) - strlen($uid) - strlen($extension) - 3;

        // Ensure max_length is valid
        if ($max_length < 1) {
            $safe_name = 'unnamed';
        } else {
            $safe_name = substr($original_name, 0, $max_length);
        }
        return "{$prefix}-{$safe_name}-{$uid}.{$extension}";
    }

    /**
     * Resize and crop image like object-fit: cover and save it.
     *
     * @param \Illuminate\Http\UploadedFile|string $imageFile Uploaded file or path
     * @param string $folder Storage folder relative to 'public'
     * @param string $filename Desired filename
     * @param int $targetWidth Target width in pixels
     * @param int $targetHeight Target height in pixels
     * @param string $format Desired format: 'png' or 'jpeg'
     * @param int|null $quality Quality for jpeg (0-100), ignored for png
     * @return string Saved path relative to storage disk
     */
    public function saveImage(
        $imageFile,
        string $folder,
        string $filename,
        int $targetWidth = 200,
        int $targetHeight = 200,
        string $format = 'png',
        ?int $quality = null,
        ?string $disk = 'uploads'
    ) {
        $driver = new GdDriver();
        // Create ImageManager instance
        $manager = new ImageManager($driver);
        // Read the image
        $image = $manager->read($imageFile);
        // Get original dimensions
        $origWidth = $image->width();
        $origHeight = $image->height();
        // Calculate scale to cover area
        $scale = max($targetWidth / $origWidth, $targetHeight / $origHeight);
        $newWidth = intval($origWidth * $scale);
        $newHeight = intval($origHeight * $scale);
        // Resize and crop
        $image->resize($newWidth, $newHeight)->crop(
            $targetWidth,
            $targetHeight,
            intval(($newWidth - $targetWidth) / 2),
            intval(($newHeight - $targetHeight) / 2)
        );
        // Encode image in desired format
        $imageData = ($format === 'jpeg' || $format === 'jpg') ?
            $image->toJpeg($quality ?? 80) : $image->toPng();
        // Save to disk
        $path = "$folder/$filename";
        Storage::disk($disk)->put($path, (string) $imageData);
        return $path;
    }

}
