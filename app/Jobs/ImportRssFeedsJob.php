<?php

namespace App\Jobs;

use App\Services\RssFeedService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportRssFeedsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    public int $timeout = 300;

    public function handle(RssFeedService $rssFeedService): void
    {
        $results = $rssFeedService->importAllFeeds();

        Log::info('Scheduled RSS import completed', [
            'success' => $results['success'],
            'skipped' => $results['skipped'],
            'errors' => $results['errors'],
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Scheduled RSS import failed', [
            'error' => $exception->getMessage(),
        ]);
    }
}
