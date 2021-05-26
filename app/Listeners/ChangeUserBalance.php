<?php

namespace App\Listeners;

use App\Events\CheckVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeUserBalance
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
     * @param CheckVerified $event
     * @return void
     */
    public function handle(CheckVerified $event)
    {
        $checkHistory = $event->checkHistory;
        $user = $event->user;
        $user->balance = $user->balance + $checkHistory->reward;
        $user->save();
    }
}
