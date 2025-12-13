<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenWebNinjaService
{
    protected string $baseUrl = 'https://api.openwebninja.com';

    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openwebninja.api_key');
    }

    /**
     * Search for real-time events using OpenWebNinja API.
     *
     * @param  string  $query  Search keyword (required)
     * @param  string|null  $date  Date filter (any, today, tomorrow, week, weekend, next_week, month, next_month)
     * @param  bool  $isVirtual  Filter virtual events only
     * @param  int  $start  Pagination start index
     * @return array Response containing events data and status
     */
    public function searchEvents(
        string $query,
        ?string $date = 'any',
        bool $isVirtual = false,
        int $start = 0
    ): array {
        try {
            if (empty($this->apiKey)) {
                Log::error('OpenWebNinja API key not configured', [
                    'config_value' => config('services.openwebninja.api_key'),
                    'help' => 'Add OPEN_WEB_NINJA_API_KEY to your .env file and run php artisan config:cache. See EVENTS_SETUP.md for detailed instructions.',
                ]);

                return [
                    'success' => false,
                    'error' => 'API key not configured. Please add OPEN_WEB_NINJA_API_KEY to your .env file and run php artisan config:cache. See EVENTS_SETUP.md for setup instructions.',
                    'data' => null,
                ];
            }

            $params = [
                'query' => $query,
                'is_virtual' => $isVirtual ? 'true' : 'false',
                'start' => $start,
            ];

            // Only add date if it's not 'any'
            if ($date && $date !== 'any') {
                $params['date'] = $date;
            }

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])
                ->timeout(30)
                ->get("{$this->baseUrl}/realtime-events-data", $params);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'error' => null,
                ];
            }

            $statusCode = $response->status();
            $errorMessage = $response->json('message') ?? $response->body();

            // Provide helpful error message for common issues
            if ($statusCode === 403) {
                $errorMessage = 'Authentication failed. Please verify your OPEN_WEB_NINJA_API_KEY is correctly set in your .env file. See EVENTS_SETUP.md for help.';
            }

            Log::error('OpenWebNinja API error', [
                'status' => $statusCode,
                'message' => $errorMessage,
                'api_key_configured' => ! empty($this->apiKey),
                'api_key_length' => $this->apiKey ? strlen($this->apiKey) : 0,
            ]);

            return [
                'success' => false,
                'error' => "API request failed with status {$statusCode}: {$errorMessage}",
                'data' => null,
            ];
        } catch (\Exception $e) {
            Log::error('OpenWebNinja API exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Search for multiple event types in parallel.
     *
     * @param  array  $queries  Array of search queries
     * @param  string|null  $date  Date filter
     * @param  bool  $isVirtual  Filter virtual events
     * @return array Combined results from all queries
     */
    public function searchMultipleEvents(
        array $queries,
        ?string $date = 'any',
        bool $isVirtual = false
    ): array {
        $allEvents = [];
        $errors = [];

        foreach ($queries as $query) {
            $result = $this->searchEvents($query, $date, $isVirtual);

            if ($result['success'] && isset($result['data']['events'])) {
                $allEvents = array_merge($allEvents, $result['data']['events']);
            } else {
                $errors[] = "Failed to fetch events for query '{$query}': ".($result['error'] ?? 'Unknown error');
            }
        }

        return [
            'success' => ! empty($allEvents) || empty($errors),
            'events' => $allEvents,
            'errors' => $errors,
        ];
    }
}
