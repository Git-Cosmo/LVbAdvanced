<?php

namespace App\Services;

use App\Models\AzuracastRequest;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Handles Azuracast API interactions for live radio data and song requests.
 */
class AzuracastService
{
    protected string $baseUrl;
    protected string $stationId;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.azuracast.base_url'), '/');
        $this->stationId = (string) config('services.azuracast.station_id');
        $this->apiKey = config('services.azuracast.api_key');
    }

    /**
     * Fetch now playing payload with current, next, and recent tracks.
     *
     * @return array{now_playing:mixed, playing_next:mixed, song_history:array, is_online:mixed}
     */
    public function nowPlaying(): array
    {
        $response = $this->http()->get(
            $this->endpoint("api/nowplaying/{$this->stationId}")
        )->throw()->json();

        return [
            'now_playing' => $response['now_playing'] ?? null,
            'playing_next' => $response['playing_next'] ?? null,
            'song_history' => $response['song_history'] ?? [],
            'is_online' => $response['is_online'] ?? null,
        ];
    }

    /**
     * Retrieve requestable songs for the configured station.
     *
     * @return array
     */
    public function requestableSongs(): array
    {
        return $this->http()->get(
            $this->endpoint("api/station/{$this->stationId}/requests")
        )->throw()->json();
    }

    /**
     * Submit a song request and log the attempt.
     *
     * @param string $requestId
     * @param int|null $userId
     * @return AzuracastRequest
     */
    public function requestSong(string $requestId, ?int $userId = null): AzuracastRequest
    {
        $log = AzuracastRequest::create([
            'user_id' => $userId,
            'request_id' => $requestId,
            'status' => 'pending',
        ]);

        try {
            $response = $this->http()->post(
                $this->endpoint("api/station/{$this->stationId}/request/{$requestId}")
            );

            $payload = $response->json();
            $message = is_array($payload)
                ? ($payload['message'] ?? $payload['error'] ?? null)
                : null;

            $log->status = $response->successful() ? 'success' : 'failed';
            $log->api_response_message = $message ?? $response->reason();
        } catch (\Throwable $e) {
            $log->status = 'failed';
            $log->api_response_message = $e->getMessage();

            Log::warning('Azuracast request failed', [
                'request_id' => $requestId,
                'error' => $e->getMessage(),
            ]);
        }

        $log->save();

        return $log;
    }

    protected function http(): PendingRequest
    {
        $request = Http::timeout(10)->acceptJson();

        if ($this->apiKey) {
            $request = $request->withHeaders([
                'X-API-Key' => $this->apiKey,
            ]);
        }

        return $request;
    }

    protected function endpoint(string $path): string
    {
        return $this->baseUrl . '/' . ltrim($path, '/');
    }
}
