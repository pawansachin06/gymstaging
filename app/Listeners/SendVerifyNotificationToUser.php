<?php

namespace App\Listeners;

use App\Events\ListingVerified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\UserVerifyNotification;
use Mail;
use App\Models\Verification;
use Auth;
use App\Models\Notification;

class SendVerifyNotificationToUser
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
    public function handle(ListingVerified $event)
    {
        $listing = $event->listing;
        $verification = $listing->verifications()->latest()->first();
        $user =  $listing->user;
        try {
            if ($verification && $listing->verified == 1) {
                $this->createNotification([
                    'table_class' => Verification::class,
                    'table_id' => $verification->id,
                    'sender_id' => Auth::user()->id,
                    'receiver_id' => $user->id,
                    'message' => 'Your account has been verified!',
                    'mark_as_read' => 0
                ]);
            }
        }catch (\Exception $e){}
        Mail::to($user->email)->send(new UserVerifyNotification($listing,$user));
    }

    protected function createNotification($data){
        if($data['sender_id'] == $data['receiver_id']){
            return;
        }
        $notification = new Notification();
        $notification->fill($data);
        $notification->save();
    }


}
