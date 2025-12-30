<?php

namespace App\Console\Commands;

use App\Jobs\CheckCveQueriesJob;
use Illuminate\Console\Command;

class CheckCveQueries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cve:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually trigger CVE query checking';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Dispatching CVE query check job...');

        CheckCveQueriesJob::dispatch();

        $this->info('Job dispatched to queue.');
        $this->comment('Run "sail artisan queue:work" to process the job');

        return 0;
    }
}
