<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestBoostNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;

    public $listing;
    public $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($boost)
    {
        $this->listing = $boost->listing;
        $this->owner = $this->listing->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->owner->email)
            ->subject('Review Boost Requested')
            ->markdown('emails.listingboostnotification')->with(['owner' => $this->owner, 'listing' => $this->listing]);

    }
}
