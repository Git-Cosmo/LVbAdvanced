<?php

use App\Jobs\ImportEventsJob;
use App\Jobs\ImportRssFeedsJob;
use App\Jobs\SyncCheapSharkJob;
use App\Services\CheapSharkService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('cheapshark:sync {--runType=manual}', function (CheapSharkService $cheapSharkService) {
    $runType = $this->option('runType');
    $log = $cheapSharkService->runSync($runType);

    $this->info($log->message ?? 'Sync finished with status: '.$log->status);
})->purpose('Sync CheapShark stores, games, and deals');

// NOTE: To enable scheduled automation, ensure that `php artisan schedule:run` is configured to run every minute in your system's cron or task scheduler.
Schedule::job(new SyncCheapSharkJob())
    ->withoutOverlapping()
    ->monitorName('cheapshark-sync')
    ->graceTimeInMinutes(10) // Allow up to 10 minutes for hourly jobs before flagging as late
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

// Reddit scraping every 2 hours
Schedule::command('reddit:scrape')
    ->withoutOverlapping()
    ->everyTwoHours();

// StreamerBans scraping daily (update existing streamers)
Schedule::command('streamerbans:scrape --update --limit=100')
    ->withoutOverlapping()
    ->daily();

// Patch Notes scraping hourly
Schedule::command('patch-notes:scrape')
    ->withoutOverlapping()
    ->monitorName('patch-notes-scrape')
    ->graceTimeInMinutes(10)
    ->hourly();
