<?php

namespace App\Jobs;

use App\Services\Admin\ModeratorService;
use Illuminate\Bus\Queueable;
use App\Services\CheckService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class ProcessAddingChecks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 60*60;
    public $retryAfter = 60*60+10;
    public $limit;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($limit = 100)
    {
        $this->limit = $limit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $moderatorService = new ModeratorService();
        $checkService = new CheckService();

        $checks = $checkService->getChecksFromApi([
            'token_id' => $moderatorService->getToken(),
            'limit' => $this->limit,
            'page' => 1,
        ]);

        $checkService->addChecks($checks);
    }
}
