<?php

namespace App\Events;

use App\Models\Boost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestBoost
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $boost;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Boost $boost)
    {
        $this->boost = $boost;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
