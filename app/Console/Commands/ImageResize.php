<?php

namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageResize extends Command
{
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uploadPath = storage_path('app/public');
        $specificFile = $this->option('file');
        $files = File::files(public_path($this->option('path')));
        if (file_exists($uploadPath)) {
            chmod($uploadPath, 0755);
        }
        $i = 0;
        foreach ($files as $file) {
            if($specificFile && $file->getFileName() != $specificFile){
                continue;
            }
            $info = pathinfo($file->getRealPath());
            $ext = strtolower($info['extension']);

            if (in_array($ext,['png', 'jpg', 'jpeg', 'gif'])) {
                try {
                    $resize_image = Image::make($file->getRealPath());
                    $resize_image->resize(800, 400, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($uploadPath . '/' . $file->getFileName());
                } catch (\Exception $e) {
                    $this->info("ERROR: {$e->getMessage()} for {$file->getFileName()}");
                }
            }
        }
    }
}
