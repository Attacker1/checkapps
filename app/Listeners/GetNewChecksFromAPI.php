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
        $settings = Setting::query()->whereIn('slug', [SettingSlugEnum::CHECK_MINIMAL_LIMIT['slug'], SettingSlugEnum::CHECK_GET_QUANTITY['slug']])->get();
        $minimalLimit = $settings->first(function($item) {
            return $item->slug == SettingSlugEnum::CHECK_MINIMAL_LIMIT['slug'];
        })->value ?? 1000;

        if($count < $minimalLimit) {
            $getCuantity = $settings->first(function($item) {
                return $item->slug == SettingSlugEnum::CHECK_GET_QUANTITY['slug'];
            })->value ?? 5000;

            ProcessAddingChecks::dispatch($getCuantity);
        }
    }
}
