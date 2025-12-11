<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\CheapSharkService;
use App\Jobs\ImportRssFeedsJob;
use App\Jobs\SyncCheapSharkJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('cheapshark:sync {--runType=manual}', function (CheapSharkService $cheapSharkService) {
    $runType = $this->option('runType');
    $log = $cheapSharkService->runSync($runType);

    $this->info($log->message ?? 'Sync finished with status: ' . $log->status);
})->purpose('Sync CheapShark stores, games, and deals');

use App\Jobs\ImportEventsJob;

// NOTE: To enable scheduled automation, ensure that `php artisan schedule:run` is configured to run every minute in your system's cron or task scheduler.
Schedule::job(new SyncCheapSharkJob())
    ->withoutOverlapping()
    ->monitorName('cheapshark-sync')
    ->graceTimeInMinutes(10)
    ->hourly();

Schedule::job(new ImportRssFeedsJob())
    ->withoutOverlapping()
    ->monitorName('rss-import')
    ->graceTimeInMinutes(10)
    ->hourly();

Schedule::job(new ImportEventsJob())
    ->withoutOverlapping()
    ->monitorName('events-import')
    ->graceTimeInMinutes(10)
    ->hourly();
