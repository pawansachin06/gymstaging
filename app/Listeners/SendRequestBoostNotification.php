<?php

namespace App\Listeners;

use App\Events\RequestBoost;
use App\Mail\RequestBoostNotification;
use App\Models\Boost;
use App\Models\Notification;
use App\Models\User;
use Auth;
use Mail;

class SendRequestBoostNotification
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
    public function handle(RequestBoost $event)
    {
        $boost = $event->boost;
        try {
            $admin_id = User::where('role_id', User::ROLE_ADMIN)->first();
            $this->createNotification([
                'table_class' => Boost::class,
                'table_id' => $boost->id,
                'sender_id' => Auth::user()->id,
                'receiver_id' => $admin_id->id,
                'message' => "{$boost->listing->user->name} has requested review boost",
                'mark_as_read' => 0
            ]);
            Mail::to(env('VERIFY_NOTIFICATION'), config('mail.from.name'))->send(new RequestBoostNotification($boost));
        } catch (\Exception $e) {
        }
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
