<?php

namespace App\Listeners;

use App\Events\ListingCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ListingcreateNotification;
use Mail;

class SendListingCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(ListingCreated $event)
    {
        $listing = $event->listing;
        Mail::to($listing->user->email)->send(new ListingcreateNotification($listing));
    }

}
