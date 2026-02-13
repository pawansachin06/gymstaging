<?php

namespace App\Mail;

use App\Models\Boost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserBoostNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;

    public $listing;
    public $user;

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
        if ($this->listing->boosted != Boost::APPROVED) {
            return;
        }

        return $this->from(env('SALE_NOTIFICATION'), config('mail.from.name'))
            ->subject('Your business reviews are Boosted!')
            ->markdown('emails.userboostnotification')->with(['user' => $this->user, 'listing' => $this->listing]);
    }
}
