<?php

use App\Jobs\CheckCveQueriesJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run CVE checks daily at 6 AM
Schedule::job(new CheckCveQueriesJob())
    ->dailyAt('06:00')
    ->name('cve-queries-check')
    ->onOneServer();
