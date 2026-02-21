<?php

namespace App\Console\Commands;

use App\Models\Listing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Exception;

class GenerateListingMarkers extends Command
{
    protected $signature = 'app:generate-listing-markers';

    protected $description = 'Command description';

    public function handle()
    {
        try {
            $this->info('Cleaning markers folder...');
            $markerPath = storage_path('app/public/markers');
            if (File::exists($markerPath)) {
                File::deleteDirectory($markerPath);
            }
            File::makeDirectory($markerPath, 0755, true);

            $this->info('Generating markers...');
            Listing::query()
                ->select(['id', 'profile_image'])
                ->whereNotNull('profile_image')
                ->orderBy('id')
                ->chunkById(500, function ($listings) {
                    foreach ($listings as $listing) {
                        Artisan::call('image:marker', [
                            '--file' => $listing->profile_image
                        ]);
                    }
                });
    
            $this->newLine();
            $this->info('Markers generated successfully.');
            return self::SUCCESS;
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $this->error($msg);
        }
    }
}
