<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessAddingChecks;
use Illuminate\Support\Facades\Log;

class ChecksAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checks:add {--limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавляет чеки в базу с запросом на finiko api';

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
     * @return void
     */
    public function handle()
    {
        ProcessAddingChecks::dispatch($this->option('limit'));
    }
}
