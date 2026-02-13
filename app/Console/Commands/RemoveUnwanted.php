<?php

namespace App\Console\Commands;

use App\Models\Listing;
use App\Models\ListingReview;
use App\Models\Notification;
use Illuminate\Console\Command;

class RemoveUnwanted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:unwanted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove deleted records';

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
        Listing::query()->doesntHave('user')->delete();
        Notification::query()->doesntHave('sender')->orDoesntHave('receiver')->delete();
        ListingReview::query()->doesntHave('user')->orDoesntHave('listing')->delete();
    }
}
