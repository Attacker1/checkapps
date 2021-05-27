<?php
namespace App\Repositories;
use App\Models\Check;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class CheckRepository
{
    public function getByExpirityTimeout(int $timeInSeconds) : Collection
    {
        $date = Carbon::createFromTimeStamp(time() - $timeInSeconds)->toDateTimeString();
        return Check::where([
            ['updated_at', '<=', $date],
            ['check_user_id', '!=', null],
        ])->get();
    }
}
