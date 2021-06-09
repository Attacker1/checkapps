<?php

namespace App\Jobs;

use App\Models\Check;
use App\Repositories\CheckRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveExpiredChecks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $checkRepository = new CheckRepository();
        $checks = $checkRepository->getExpiredChecks()->get('check_id')->pluck('check_id');

        if(!empty($checks)) {
            Check::destroy($checks);
        }
    }
}
