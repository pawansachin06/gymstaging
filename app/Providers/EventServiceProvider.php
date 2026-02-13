<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ReviewCreated' => [
            'App\Listeners\SendReviewNotification',
        ],
        'App\Events\UserRegistered' => [
            'App\Listeners\SendRegisteredNotification',
        ],
        'App\Events\ListingCreated' => [
            'App\Listeners\SendListingCreatedNotification',
        ],
        'App\Events\RequestVerification' => [
            'App\Listeners\SendRequestVerificationNotification',
        ],
        'App\Events\RequestBoost' => [
            'App\Listeners\SendRequestBoostNotification',
        ],
        'App\Events\ListingVerified' => [
            'App\Listeners\SendVerifyNotificationToUser',
        ],
        'App\Events\ListingBoosted' => [
            'App\Listeners\SendBoostNotificationToUser',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
