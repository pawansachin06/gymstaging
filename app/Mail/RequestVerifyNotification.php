<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Setting;

class RequestVerifyNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;
    public $listing;
    public $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verification)
    {
        $this->listing = $verification->listing;
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
        ->subject('Verification Requested')
        ->markdown('emails.listingverifynotification')->with(['owner'=> $this->owner,'listing'=>$this->listing]);
            
    }
}
