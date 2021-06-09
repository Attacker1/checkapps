<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\RequestNewChecks;
use Illuminate\Support\Facades\Log;

class InspectChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checks:inspect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверяет количество чеков в базе и если меньше определенного количества то, запрости еще с API';

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
        event(new RequestNewChecks());
        Log::info('Команда по проверке количества чеков выполнена');
    }
}
