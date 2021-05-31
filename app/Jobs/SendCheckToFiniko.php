<?php

namespace App\Jobs;

use App\Client\JsonRpcClient;
use App\Enum\CheckHistoryStatusEnum;
use App\Enum\CheckStatusEnum;
use App\Models\Check;
use App\Services\Admin\ModeratorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCheckToFiniko implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $check;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Check $checkWithCheckHistory)
    {
        $this->check = $checkWithCheckHistory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $moderatorService = new ModeratorService();
        $client = new JsonRpcClient();
        $checkStatus = $this->check->status;
        $isReject = $checkStatus === CheckStatusEnum::REJECT;
        $finikoAPIRoute = $isReject ? 'Cashback/Moderator/reject' : 'Cashback/Moderator/accept';
        $token_id = $moderatorService->getToken();

        $params = [
            'token_id' => $token_id,
            'id' => $this->check->check_id,
        ];

        if($isReject) {
            $comments = [];
            $comparator = CheckHistoryStatusEnum::REJECTED;

            foreach ($this->check->checkHistory as $history) {
                if ($history->status === $comparator) {
                    $comments[] = $history->comment;
                }
            }

            $params['comment'] = implode(';', $comments);
        }

        $response = $client->send($finikoAPIRoute, $params);

        if(isset($response->error)) {
            Log::info($response);
        }
    }
}
