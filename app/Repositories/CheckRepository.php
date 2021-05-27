<?php
namespace App\Repositories;
use App\Models\Check;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CheckRepository
{
    public function getByExpirityTimeout(int $timeInSeconds) : Builder
    {
        $date = Carbon::createFromTimeStamp(time() - $timeInSeconds)->toDateTimeString();
        return Check::where([
            ['updated_at', '<=', $date],
            ['check_user_id', '!=', null],
        ]);
    }
}
