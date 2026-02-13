<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Setting;

class ListingcreateNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;

    public $listing;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($listing)
    {
        $this->listing = $listing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $listing = $this->listing;

        $user = $listing->user;

        return $this->from(env('SALE_NOTIFICATION'), config('mail.from.name'))
            ->subject('Welcome to GymSelect')
            ->markdown('emails.listingcreatenotification_'.$listing->business_id)
            ->with([
                'name'=> $user->name,
                'email' => $user->email,
                'slug' => $listing->slug,
                'webUrl' => $listing->webUrl
            ]);
    }
}
