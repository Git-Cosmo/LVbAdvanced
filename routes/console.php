<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\CheapSharkService;
use App\Jobs\ImportRssFeedsJob;
use App\Jobs\SyncCheapSharkJob;
use App\Jobs\ImportEventsJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('cheapshark:sync {--runType=manual}', function (CheapSharkService $cheapSharkService) {
    $runType = $this->option('runType');
    $log = $cheapSharkService->runSync($runType);

    $this->info($log->message ?? 'Sync finished with status: ' . $log->status);
})->purpose('Sync CheapShark stores, games, and deals');

const SCHEDULE_GRACE_MINUTES = 10; // Allow up to 10 minutes for hourly jobs before flagging as late

// NOTE: To enable scheduled automation, ensure that `php artisan schedule:run` is configured to run every minute in your system's cron or task scheduler.
Schedule::job(new SyncCheapSharkJob())
    ->withoutOverlapping()
    ->monitorName('cheapshark-sync')
    ->graceTimeInMinutes(SCHEDULE_GRACE_MINUTES)
    ->hourly();

Schedule::job(new ImportRssFeedsJob())
    ->withoutOverlapping()
    ->monitorName('rss-import')
    ->graceTimeInMinutes(SCHEDULE_GRACE_MINUTES)
    ->hourly();

Schedule::job(new ImportEventsJob())
    ->withoutOverlapping()
    ->monitorName('events-import')
    ->graceTimeInMinutes(SCHEDULE_GRACE_MINUTES)
    ->hourly();
