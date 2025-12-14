<?php

namespace App\Services;

use App\Models\Streamer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwitchApiService
{
    private string $clientId;
    private string $clientSecret;
    private string $baseUrl = 'https://api.twitch.tv/helix';

    public function __construct()
    {
        $this->clientId = config('services.twitch.client_id', '');
        $this->clientSecret = config('services.twitch.client_secret', '');
    }

    public function getAccessToken(): ?string
    {
        return Cache::remember('twitch_access_token', 3600, function () {
            try {
                $response = Http::post('https://id.twitch.tv/oauth2/token', [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'client_credentials',
                ]);

                if ($response->successful()) {
                    return $response->json('access_token');
                }

                Log::error('Failed to get Twitch access token', ['response' => $response->body()]);
                return null;
            } catch (\Exception $e) {
                Log::error('Twitch API error: '.$e->getMessage());
                return null;
            }
        });
    }

    public function getTopStreams(int $limit = 20): array
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return [];
        }

        try {
            $response = Http::withHeaders([
                'Client-ID' => $this->clientId,
                'Authorization' => 'Bearer '.$token,
            ])->get($this->baseUrl.'/streams', [
                'first' => $limit,
                'type' => 'live',
            ]);

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::error('Failed to fetch Twitch streams', ['response' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Twitch streams fetch error: '.$e->getMessage());
            return [];
        }
    }

    public function syncTopStreamers(int $limit = 20): int
    {
        $streams = $this->getTopStreams($limit);
        $synced = 0;

        foreach ($streams as $stream) {
            try {
                // Get user info for profile image
                $userInfo = $this->getUserInfo($stream['user_id']);

                Streamer::updateOrCreate(
                    [
                        'platform' => 'twitch',
                        'username' => $stream['user_login'],
                    ],
                    [
                        'display_name' => $stream['user_name'],
                        'profile_image_url' => $userInfo['profile_image_url'] ?? null,
                        'channel_url' => 'https://twitch.tv/'.$stream['user_login'],
                        'is_live' => true,
                        'viewer_count' => $stream['viewer_count'],
                        'stream_title' => $stream['title'],
                        'game_name' => $stream['game_name'] ?? null,
                        'thumbnail_url' => str_replace(['{width}', '{height}'], ['440', '248'], $stream['thumbnail_url']),
                        'stream_started_at' => $stream['started_at'],
                        'last_checked_at' => now(),
                    ]
                );

                $synced++;
            } catch (\Exception $e) {
                Log::error('Error syncing Twitch streamer: '.$e->getMessage(), ['stream' => $stream]);
            }
        }

        // Mark offline streamers
        Streamer::where('platform', 'twitch')
            ->where('is_live', true)
            ->where('last_checked_at', '<', now()->subMinutes(5))
            ->update(['is_live' => false]);

        return $synced;
    }

    private function getUserInfo(string $userId): ?array
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Client-ID' => $this->clientId,
                'Authorization' => 'Bearer '.$token,
            ])->get($this->baseUrl.'/users', [
                'id' => $userId,
            ]);

            if ($response->successful()) {
                $data = $response->json('data', []);
                return $data[0] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Twitch user info fetch error: '.$e->getMessage());
            return null;
        }
    }
}
