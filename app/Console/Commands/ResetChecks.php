<?php

namespace App\Console\Commands;

use App\Jobs\ClearUserExpiredChecks;
use Illuminate\Console\Command;

class ResetChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checks:reset {--time=3600}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        ClearUserExpiredChecks::dispatch($this->option('time'));
    }
}
