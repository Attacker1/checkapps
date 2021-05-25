<?php

namespace App\Jobs;

use App\Client\JsonRpcClient;
use Illuminate\Bus\Queueable;
use App\Services\CheckService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessAddingChecks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $retryAfter = 0;
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
        $client = new JsonRpcClient();
        $checkService = new CheckService($client);

        $moderator = $client->send('User/login', [
            'login' => 'chekapps.com@gmail.com',
            'password' => 'HvJTP.3m,F5KtnH',
        ]);

        $checks = $checkService->getChecksFromApi([
            'token_id' => $moderator->token_id,
            'limit' => $this->limit,
            'page' => 1,
        ]);

        $checkService->addChecks($checks);
    }
}
