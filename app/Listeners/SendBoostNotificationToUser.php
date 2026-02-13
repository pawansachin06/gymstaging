<?php

namespace App\Listeners;

use App\Events\ListingBoosted;
use App\Mail\UserBoostNotification;
use App\Models\Boost;
use App\Models\Notification;
use Auth;
use Mail;

class SendBoostNotificationToUser
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
    public function handle(ListingBoosted $event)
    {
        $listing = $event->listing;
        $boost = $listing->boosts()->latest()->first();
        $user = $listing->user;
        try {
            if ($boost && $listing->boosted == 1) {
                $this->createNotification([
                    'table_class' => Boost::class,
                    'table_id' => $boost->id,
                    'sender_id' => Auth::user()->id,
                    'receiver_id' => $user->id,
                    'message' => 'Review Boost Complete',
                    'mark_as_read' => 0
                ]);
            }
        } catch (\Exception $e) {
        }
        Mail::to($user->email)->send(new UserBoostNotification($listing, $user));
    }

    protected function createNotification($data)
    {
        if ($data['sender_id'] == $data['receiver_id']) {
            return;
        }
        $notification = new Notification();
        $notification->fill($data);
        $notification->save();
    }


}
