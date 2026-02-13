<?php

namespace App\Mail;

use App\Models\ListingReview;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportAbuseNotification extends Mailable implements ShouldQueue
{
    use SerializesModels;
    public $message;
    public $listingSlug;
    public $review_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, ListingReview $model)
    {
        $this->message =  $message;
        $this->listingSlug = @$model->listing->slug;
        $this->review_id = @$model->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject('Report Abuse')
        ->markdown('emails.reportabusenotification')
        ->with(['message' =>  $this->message,'slug' => $this->listingSlug, 'review_id' => $this->review_id]);
            
    }
}
