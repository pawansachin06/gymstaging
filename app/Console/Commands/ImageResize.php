<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageResize extends Command
{
    protected ImageManager $manager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "imageresize {--path=} {--file=}";
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "image rezie for uploaded files";

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
        $uploadPath = storage_path('app/public');
        $specificFile = $this->option('file');
        $sourcePath   = public_path($this->option('path'));

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $files = File::files($sourcePath);

        foreach ($files as $file) {
            if ($specificFile && $file->getFilename() !== $specificFile) {
                continue;
            }

            $info = pathinfo($file->getRealPath());
            $ext = strtolower($file->getExtension());

            if (!in_array($ext, ['png','jpg','jpeg','gif'])) {
                continue;
            }

            try {
                $image = $this->manager->read($file->getRealPath());
                $image = $image->scaleDown(800, 400);
                $image->save($uploadPath . '/' . $file->getFilename());

                // $resize_image = Image::make($file->getRealPath());
                // $resize_image->resize(800, 400, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($uploadPath . '/' . $file->getFileName());
            } catch (\Exception $e) {
                $this->info("ERROR: {$e->getMessage()} for {$file->getFileName()}");
            }
        }
    }
}
