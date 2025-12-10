<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\CheapSharkService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('cheapshark:sync {--runType=manual}', function (CheapSharkService $cheapSharkService) {
    $runType = $this->option('runType');
    $log = $cheapSharkService->runSync($runType);

    $this->info($log->message ?? 'Sync finished with status: ' . $log->status);
})->purpose('Sync CheapShark stores, games, and deals');

// NOTE: To enable scheduled tasks, ensure that `php artisan schedule:run` is configured to run every minute in your system's cron or task scheduler.
Schedule::command('cheapshark:sync --runType=scheduled')->hourly();
