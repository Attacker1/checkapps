<?php

namespace App\Listeners;

use App\Enum\SettingSlugEnum;
use App\Events\CheckVerified;
use App\Models\Setting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreareCheckVerifyQuantity
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
        $oldValue = $check->current_quantity;
        $newValue = $oldValue + 1;
        $maxVerifyQuantity = Setting::first('slug', SettingSlugEnum::CHECK_VERIFY_QUANTITY)->value;

        $check->current_quantity = $newValue;
        $check->save();

        if($newValue === $maxVerifyQuantity) {
            // Здесь вызывать ивент закрытия чека
        }
    }
}
