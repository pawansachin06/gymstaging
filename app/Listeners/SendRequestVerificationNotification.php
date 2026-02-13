<?php

namespace App\Listeners;

use App\Events\RequestVerification;
use App\Mail\RequestVerifyNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Models\Setting;
use App\Models\Verification;
use Auth;
use App\Models\Notification;
use App\Models\User;

class SendRequestVerificationNotification
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
    public function handle(RequestVerification $event)
    {
        $verification = $event->verification;
        try {
            $admin_id = User::where('role_id', User::ROLE_ADMIN)->first();
            $this->createNotification([
                'table_class' => Verification::class,
                'table_id' => $verification->id,
                'sender_id' => Auth::user()->id,
                'receiver_id' => $admin_id->id,
                'message' => "{$verification->listing->user->name} has requested verification",
                'mark_as_read' => 0
            ]);
            Mail::to(env('VERIFY_NOTIFICATION'), config('mail.from.name'))->send(new RequestVerifyNotification($verification));
        }catch (\Exception $e){}
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
