<?php

namespace App\Mail;

use App\Models\Listing;
use App\Models\Verification;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Setting;

class UserVerifyNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;
    public $listing;
    public $user;
    public $approved = false;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($listing, $user)
    {
        $this->listing = $listing;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->listing->verified != Verification::APPROVED) {
            return;
        }

        return $this->from(env('SALE_NOTIFICATION'), config('mail.from.name'))
            ->subject('You are Verified!')
            ->markdown('emails.userverifynotification')->with(['user'=>$this->user,'listing' => $this->listing, 'approved' => $this->approved]);
    }
}
