<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Notification extends Mailable implements ShouldQueue
{
    use SerializesModels;
    public $name ,$email , $subject , $message ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name , $email , $subject , $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject =  $subject;
        $this->message =  $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->replyTo($this->email)->subject($this->subject)
        ->markdown('emails.contactnotification')
        ->with(['name'=> $this->name , 'email' => $this->email , 'subject' =>  $this->subject , 'message' =>  $this->message]); 
            
    }
}
