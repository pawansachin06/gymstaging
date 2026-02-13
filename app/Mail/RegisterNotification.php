<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Setting;

class RegisterNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;

        return $this->from(env('REPORT_NOTIFICATION'), config('mail.from.name'))
            ->subject('Activate Your Account')
            ->markdown('emails.registernotification')->with(['name'=> $user->name , 'email' => $user->email,'token' => $user->verify_token]);
    }
}
