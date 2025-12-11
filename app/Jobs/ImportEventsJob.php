<?php

namespace App\Jobs;

use App\Services\EventsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ImportEventsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(EventsService $eventsService): void
    {
        try {
            Log::info('Starting scheduled events import');
            
            $results = $eventsService->scrapeEvents();
            
            Log::info('Events import completed', [
                'success' => $results['success'],
                'skipped' => $results['skipped'],
                'errors' => $results['errors'],
            ]);
        } catch (\Exception $e) {
            Log::error('Events import job failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            throw $e;
        }
    }
}
