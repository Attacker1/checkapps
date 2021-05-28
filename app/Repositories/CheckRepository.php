<?php

namespace App\Repositories;

use App\Enum\SettingSlugEnum;
use App\Models\Check;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CheckRepository
{
    public function getByExpirityTimeout(int $timeInSeconds): Builder
    {
        $date = Carbon::createFromTimeStamp(time() - $timeInSeconds)->toDateTimeString();
        return Check::where([
            ['updated_at', '<=', $date],
            ['check_user_id', '!=', null],
        ]);
    }

    public function getExpiredChecks(): Builder
    {
        $expirityTime = Setting::settingBySlug(SettingSlugEnum::CHECK_EXPIRITY_TIME)->first();
        $expirityTime = $expirityTime ? (int) $expirityTime->value : 72;
        $expirityTime = $expirityTime * (60 * 60);

        $date = Carbon::createFromTimeStamp(time() - $expirityTime)->toDateTimeString();

        return Check::query()->where([
            ['dt', '<=', $date],
            ['check_user_id', '=', null],
        ])->doesntHave('checkHistory');
    }
}
