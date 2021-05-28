<?php

namespace App\Jobs;

use App\Repositories\CheckRepository;
use App\Services\CheckService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearUserExpiredChecks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $timeInSeconds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $timeInSeconds)
    {
        $this->timeInSeconds = $timeInSeconds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $checkRepository = new CheckRepository();
        $checkService = new CheckService();

        $checks = $checkRepository->getByExpirityTimeout($this->timeInSeconds);

        $checkService->resetChecks($checks);
    }
}
