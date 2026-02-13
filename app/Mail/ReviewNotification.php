<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;
    public $name , $message , $email , $sender , $slug , $review_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name , $email , $message , $sender , $slug , $review_id)
    {
        $this->name = $name;
        $this->message =  $message;
        $this->email = $email;
        $this->sender = $sender;
        $this->slug = $slug;
        $this->review_id = $review_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->sender)
            ->subject($this->message)
            ->markdown('emails.reviewnotification')->with(['name'=> $this->name , 'email' => $this->email , 'message' =>  $this->message ,'slug' => $this->slug , 'review_id' =>  $this->review_id]);
            
    }
}
