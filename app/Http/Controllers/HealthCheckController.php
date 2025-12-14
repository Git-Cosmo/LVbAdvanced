<?php

namespace App\Http\Controllers;

use App\Services\KickApiService;
use App\Services\TwitchApiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    public function index()
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'twitch_api' => $this->checkTwitchApi(),
            'kick_api' => $this->checkKickApi(),
        ];

        $overallStatus = collect($checks)->every(fn($check) => $check['status'] === 'ok');

        return response()->json([
            'status' => $overallStatus ? 'healthy' : 'degraded',
            'checks' => $checks,
            'timestamp' => now()->toIso8601String(),
        ], $overallStatus ? 200 : 503);
    }

    private function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'ok', 'message' => 'Database connection successful'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()];
        }
    }

    private function checkCache(): array
    {
        try {
            $testKey = 'health_check_' . time();
            Cache::put($testKey, 'test', 60);
            $value = Cache::get($testKey);
            Cache::forget($testKey);
            
            return $value === 'test' 
                ? ['status' => 'ok', 'message' => 'Cache is working']
                : ['status' => 'warning', 'message' => 'Cache read/write mismatch'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Cache error: ' . $e->getMessage()];
        }
    }

    private function checkTwitchApi(): array
    {
        try {
            $service = app(TwitchApiService::class);
            $token = $service->getAccessToken();
            
            return $token 
                ? ['status' => 'ok', 'message' => 'Twitch API accessible']
                : ['status' => 'warning', 'message' => 'Twitch API authentication failed'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Twitch API error: ' . $e->getMessage()];
        }
    }

    private function checkKickApi(): array
    {
        try {
            $service = app(KickApiService::class);
            $streams = $service->getTopStreams(1);
            
            return !empty($streams) || is_array($streams)
                ? ['status' => 'ok', 'message' => 'Kick API accessible']
                : ['status' => 'warning', 'message' => 'Kick API returned no data'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Kick API error: ' . $e->getMessage()];
        }
    }
}
