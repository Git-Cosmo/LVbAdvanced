<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTask;

class StatusController extends Controller
{
    public function __invoke()
    {
        $checks = collect();

        // Database check
        $checks->push($this->checkService('Database', function () {
            DB::connection()->getPdo();
        }));

        // Cache check (redis if configured)
        $checks->push($this->checkService('Cache', function () {
            Cache::store()->put('status_ping', now()->timestamp, 5);
            Cache::store()->get('status_ping');
        }));

        // Redis check
        $checks->push($this->checkService('Redis', function () {
            if (config('database.redis.client') === 'phpredis' && ! class_exists(\Redis::class)) {
                throw new \RuntimeException('phpredis extension missing');
            }

            Redis::connection()->ping();
        }));

        // Queue
        $checks->push([
            'name' => 'Queue',
            'status' => 'ok',
            'details' => 'Connection: '.config('queue.default'),
        ]);

        // Reverb
        $checks->push([
            'name' => 'Reverb',
            'status' => config('broadcasting.default') === 'reverb' ? 'ok' : 'warning',
            'details' => config('broadcasting.default') === 'reverb'
                ? 'WebSocket broadcasting configured'
                : 'Broadcast driver not set to Reverb',
        ]);

        try {
            $scheduleSummary = [
                'monitored' => MonitoredScheduledTask::count(),
                'failing' => MonitoredScheduledTask::whereNotNull('last_failed_at')->count(),
            ];
        } catch (\Throwable $e) {
            $scheduleSummary = [
                'monitored' => 0,
                'failing' => 0,
            ];

            $checks->push([
                'name' => 'Schedule Monitor',
                'status' => 'warning',
                'details' => 'Pending migrations: '.$e->getMessage(),
            ]);
        }

        return view('status', [
            'checks' => $checks,
            'scheduleSummary' => $scheduleSummary,
        ]);
    }

    protected function checkService(string $name, callable $callback): array
    {
        try {
            $callback();

            return [
                'name' => $name,
                'status' => 'ok',
                'details' => 'Healthy',
            ];
        } catch (\Throwable $e) {
            return [
                'name' => $name,
                'status' => 'error',
                'details' => $e->getMessage(),
            ];
        }
    }
}
