<?php

namespace App\Listeners;

use App\Enum\CheckHistoryStatusEnum;
use App\Enum\CheckStatusEnum;
use App\Enum\SettingSlugEnum;
use App\Events\CheckVerified;
use App\Jobs\SendCheckToFiniko;
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
        $check = $event->check;
        $oldValue = $check->current_quantity;
        $newValue = $oldValue + 1;
        $maxVerifyQuantity = Setting::settingBySlug(SettingSlugEnum::CHECK_VERIFY_QUANTITY)->first();
        $maxVerifyQuantity = $maxVerifyQuantity ? (int) $maxVerifyQuantity->value : 5;

        $check->current_quantity = $newValue;

        if($newValue === $maxVerifyQuantity) {
            $checkHistories = $check->checkHistory;
            $approved = $checkHistories->filter(function($checkHistory) {
                return $checkHistory->status === CheckHistoryStatusEnum::APPROVED;
            })->count();
            $rejected = $checkHistories->filter(function($checkHistory) {
                return $checkHistory->status === CheckHistoryStatusEnum::REJECTED;
            })->count();

            $status = $approved > $rejected ? CheckStatusEnum::APPROVE : CheckStatusEnum::REJECT;

            $check->status = $status;
        }

        $success = $check->save();

        /**
         * Данный говнокод сделан чтобы отправлять запрос в API только после успешного сохранения чека и проверки количества его проверяющих
         * А также чтобы сократить на 1 запросы на сохранение к базе
         */
        if($success && ($newValue === $maxVerifyQuantity)) {
            SendCheckToFiniko::dispatch($check);
        }
    }
}
