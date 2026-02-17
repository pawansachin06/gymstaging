<?php

namespace App\Console\Commands;

use App\Models\Traits\StorageurlTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Exception;

class RoundImage extends Command
{
    use StorageurlTrait;

    protected ImageManager $manager;

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

        $this->manager = new ImageManager(new Driver());
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
            mkdir($markerFolder, 0755, true);
            chmod($markerFolder, 0755);
        }
        $specificFile = $this->option('file');
        $files = File::files(storage_path('app/public'));

        foreach ($files as $file) {
            if ($specificFile && $file->getFileName() != $specificFile) {
                continue;
            }
            $info = pathinfo($file->getRealPath());
            $ext = strtolower($file->getExtension());

            if (!in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                continue;
            }

            try {
                $marker = $this->manager->read(public_path('gymselect/images/bubble.png'));
                $image  = $this->manager->read($file->getRealPath());
                $image = $image->cover(36, 36);
                
                $canvas = $this->manager->create($marker->width(), $marker->height());
                $canvas = $canvas->place($image, 'top-left', 14, 7);
                $canvas = $canvas->place($marker, 'top-left');
                $marker = $canvas;

                $outputPath = "{$markerFolder}/{$info['filename']}.png";
                $marker->toPng()->save($outputPath);
            } catch (Exception $e) {
                $this->info("ERROR: {$e->getMessage()} for {$file->getFileName()}");
            }
        }
    }
}
