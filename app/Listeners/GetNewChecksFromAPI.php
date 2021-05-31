<?php

namespace App\Listeners;

use App\Enum\SettingSlugEnum;
use App\Events\RequestNewChecks;
use App\Jobs\ProcessAddingChecks;
use App\Models\Check;
use App\Models\Setting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetNewChecksFromAPI
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
    public function handle(RequestNewChecks $event)
    {
        $count = Check::where('current_quantity', 0)->limit(1000)->count();
        $setting = Setting::settingBySlug(SettingSlugEnum::CHECK_MINIMAL_LIMIT)->first();
        $setting = $setting ? (int) $setting->value : 1000;

        if($count < $setting) {
            ProcessAddingChecks::dispatch(5000);
        }
    }
}
