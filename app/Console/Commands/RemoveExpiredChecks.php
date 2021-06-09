<?php

namespace App\Console\Commands;

use App\Jobs\RemoveExpiredChecks as JobsRemoveExpiredChecks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemoveExpiredChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checks:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет все чеки у которых прошло время жизни, а оно в свою очередь указывается в базе через сидер или админку';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        JobsRemoveExpiredChecks::dispatch();
         Log::info('Команда по удалению просроченых чеков выполнена');
    }
}
