<?php

namespace App\Listeners;

use App\Events\ReviewCreated;
use App\Models\ListingReview;
use App\Models\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ReviewNotification;
use Mail;

class SendReviewNotification
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
    public function handle(ReviewCreated $event)
    {
        $review = $event->review;
        $slug = $review->listing->slug;
        preg_match_all('/\(user\:([\^0-9]*)\)/', $review->message, $matches);
        $users = array_filter($matches[1]);

        if ($users) {
            foreach ($users as $user_id) {
                $this->createNotification([
                    'table_class' => ListingReview::class,
                    'table_id' => $review->id,
                    'sender_id' => $review->user_id,
                    'receiver_id' => $user_id,
                    'message' => "{$review->user->name} tagged to your review",
                    'mark_as_read' => 0
                ],  $slug);
            }
        }

        if($review->is_reply){
            $parent_review = $review->review;

            $this->createNotification([
                'table_class' => ListingReview::class,
                'table_id' => $parent_review->id,
                'sender_id' => $review->user_id,
                'receiver_id' => $parent_review->user_id,
                'message' => "{$review->user->name} replied to your review",
                'mark_as_read' => 0
            ],  $slug);
        }

        if(auth()->check()) {
            $this->createNotification([
                'table_class' => ListingReview::class,
                'table_id' => $review->id,
                'sender_id' => auth()->user()->id,
                'receiver_id' => $review->listing->user_id,
                'message' => "{$review->user->name} added review",
                'mark_as_read' => 0
            ], $slug);
        }
    }

    protected function createNotification($data ,  $slug){
        if($data['sender_id'] == $data['receiver_id']){
            return;
        }
        $notification = new Notification();
        $notification->fill($data);
        $notification->save();
        $name = $notification->receiver->name;
        $email = $notification->receiver->email;
        $message = $notification->message;
        $sender = $notification->sender->email;
        $receiver = $notification->receiver->email;
        $review = $notification->related_model();
        Mail::to($receiver)->send(new ReviewNotification($name, $email ,$message , $sender , $slug , $review->id));
    }
}
