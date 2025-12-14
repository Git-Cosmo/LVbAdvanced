<?php

namespace App\Services;

use App\Models\Streamer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KickApiService
{
    private string $baseUrl = 'https://kick.com/api/v2';

    public function getTopStreams(int $limit = 20): array
    {
        try {
            // Kick API doesn't require authentication for public endpoints
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'FPSociety/1.0',
            ])->get($this->baseUrl.'/channels', [
                'limit' => $limit,
                'sort' => 'viewers',
                'type' => 'live',
            ]);

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::error('Failed to fetch Kick streams', ['response' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Kick streams fetch error: '.$e->getMessage());
            return [];
        }
    }

    public function syncTopStreamers(int $limit = 20): int
    {
        $streams = $this->getTopStreams($limit);
        $synced = 0;

        foreach ($streams as $stream) {
            try {
                $streamStartedAt = null;
                if (isset($stream['started_at'])) {
                    try {
                        $streamStartedAt = \Carbon\Carbon::parse($stream['started_at']);
                    } catch (\Exception $e) {
                        Log::error('Failed to parse stream start time: '.$e->getMessage());
                    }
                }

                Streamer::updateOrCreate(
                    [
                        'platform' => 'kick',
                        'username' => $stream['slug'] ?? $stream['username'],
                    ],
                    [
                        'display_name' => $stream['user']['username'] ?? $stream['username'],
                        'profile_image_url' => $stream['user']['profile_pic'] ?? null,
                        'channel_url' => 'https://kick.com/'.($stream['slug'] ?? $stream['username']),
                        'is_live' => true,
                        'viewer_count' => $stream['viewers'] ?? 0,
                        'stream_title' => $stream['session_title'] ?? $stream['title'] ?? null,
                        'game_name' => $stream['category']['name'] ?? null,
                        'thumbnail_url' => $stream['thumbnail'] ?? $stream['thumbnail_url'] ?? null,
                        'stream_started_at' => $streamStartedAt,
                        'last_checked_at' => now(),
                    ]
                );

                $synced++;
            } catch (\Exception $e) {
                Log::error('Error syncing Kick streamer: '.$e->getMessage(), ['stream' => $stream]);
            }
        }

        // Mark offline streamers
        Streamer::where('platform', 'kick')
            ->where('is_live', true)
            ->where('last_checked_at', '<', now()->subMinutes(5))
            ->update(['is_live' => false]);

        return $synced;
    }
}
