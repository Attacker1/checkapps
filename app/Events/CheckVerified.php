<?php

namespace App\Events;

use App\Models\CheckHistory;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $checkHistory;
    public $check;

    /**
     * CheckVerified constructor.
     * @param $user
     * @param $checkHistory
     */
    public function __construct(User $user, CheckHistory $checkHistory)
    {
        $this->user = $user;
        $this->checkHistory = $checkHistory;
        $this->check = $this->checkHistory->check()->with('checkHistory')->first();
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('check-verified.check_id:' . $this->checkHistory->check_id);
    }
}
