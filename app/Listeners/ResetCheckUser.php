<?php

namespace App\Listeners;

use App\Events\CheckVerified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetCheckUser
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
     * @param  object  $event
     * @return void
     */
    public function handle(CheckVerified $event)
    {
        $checkHistory = $event->checkHistory;
        $check = $checkHistory->check()->first();
//        dd($check->first());

        $check->check_user_id = null;
        $check->save();
    }
}
