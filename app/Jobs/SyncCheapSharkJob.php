<?php

namespace App\Jobs;

use App\Services\CheapSharkService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncCheapSharkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 600;

    public function handle(CheapSharkService $cheapSharkService): void
    {
        $log = $cheapSharkService->runSync('scheduled');

        Log::info('Scheduled CheapShark sync completed', [
            'log_id' => $log->id,
            'status' => $log->status,
            'message' => $log->message,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Scheduled CheapShark sync failed', [
            'error' => $exception->getMessage(),
        ]);
    }
}
