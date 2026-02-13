<?php

namespace App\Console\Commands;

use App\Models\Traits\StorageurlTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class RoundImage extends Command
{
    use StorageurlTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:marker {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get a round size image';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $markerFolder = storage_path("app/public/markers");
        if (!file_exists($markerFolder)) {
            mkdir($markerFolder, 0755);
            chmod($markerFolder, 0755);
        }
        $specificFile = $this->option('file');
        $files = File::files(storage_path('app/public'));

        foreach ($files as $file) {
            if ($specificFile && $file->getFileName() != $specificFile) {
                continue;
            }
            $info = pathinfo($file->getRealPath());
            $ext = strtolower($info['extension']);

            if (in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                try {
                    $marker = Image::make(public_path('gymselect/images/bubble.png'));
                    $image = Image::make($file)->resize(36, 36);
                    $image->mask(public_path('images/mask.png'), true);
                    $marker->insert($image, 'top-left', 14, 7)->save("{$markerFolder}/{$info['filename']}.png", 90, 'png');
                } catch (\Exception $e) {
                    $this->info("ERROR: {$e->getMessage()} for {$file->getFileName()}");
                }
            }
        }
    }
}
