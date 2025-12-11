<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventImportedItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EventsService
{
    protected OpenWebNinjaService $openWebNinja;

    public function __construct(OpenWebNinjaService $openWebNinja)
    {
        $this->openWebNinja = $openWebNinja;
    }

    /**
     * Import events from OpenWebNinja API.
     * Searches for various gaming-related events.
     */
    public function importEvents(): array
    {
        $results = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];

        // Define search queries for different types of gaming events
        $queries = [
            'gaming convention',
            'esports tournament',
            'game developer conference',
            'video game expo',
            'gaming festival',
            'game launch',
            'gaming event',
        ];

        foreach ($queries as $query) {
            try {
                // Search for upcoming events
                $apiResult = $this->openWebNinja->searchEvents($query, 'month');

                if (! $apiResult['success']) {
                    $results['errors']++;
                    $results['messages'][] = "Failed to fetch events for '{$query}': ".($apiResult['error'] ?? 'Unknown error');

                    continue;
                }

                $eventsData = $apiResult['data']['events'] ?? [];

                foreach ($eventsData as $eventData) {
                    $importResult = $this->processEvent($eventData, $query);

                    if ($importResult['success']) {
                        $results['success']++;
                        $results['messages'][] = $importResult['message'];
                    } elseif ($importResult['skipped']) {
                        $results['skipped']++;
                    } else {
                        $results['errors']++;
                        $results['messages'][] = $importResult['message'];
                    }
                }
            } catch (\Exception $e) {
                $results['errors']++;
                $results['messages'][] = "Error importing events for '{$query}': {$e->getMessage()}";
                Log::error('Event import error', [
                    'query' => $query,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        return $results;
    }

    /**
     * Process a single event from the API response.
     */
    protected function processEvent(array $eventData, string $searchQuery): array
    {
        try {
            // Generate a unique external ID for deduplication
            $externalId = $this->generateExternalId($eventData);
            $source = 'openwebninja';

            // Check if already imported
            if (EventImportedItem::where('source', $source)
                ->where('external_id', $externalId)
                ->exists()) {
                return [
                    'success' => false,
                    'skipped' => true,
                    'message' => '',
                ];
            }

            // Map API response to our event model
            $mappedData = $this->mapEventData($eventData, $searchQuery);

            // Create event
            $event = Event::create($mappedData);

            // Track import
            EventImportedItem::create([
                'source' => $source,
                'external_id' => $externalId,
                'event_id' => $event->id,
            ]);

            return [
                'success' => true,
                'skipped' => false,
                'message' => "Imported: {$event->title}",
            ];
        } catch (\Exception $e) {
            Log::error('Event processing error', [
                'event_data' => $eventData,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'skipped' => false,
                'message' => "Error processing event: {$e->getMessage()}",
            ];
        }
    }

    /**
     * Generate a unique external ID for an event.
     */
    protected function generateExternalId(array $eventData): string
    {
        // Use title + start date + venue as unique identifier
        $title = $eventData['title'] ?? '';
        $startDate = $eventData['start_date'] ?? '';
        $venue = $eventData['venue']['name'] ?? '';

        return md5($title.$startDate.$venue);
    }

    /**
     * Map OpenWebNinja API response to our Event model structure.
     */
    protected function mapEventData(array $eventData, string $searchQuery): array
    {
        $title = $eventData['title'] ?? 'Untitled Event';
        $description = $eventData['description'] ?? '';
        $startDate = isset($eventData['start_date']) ? Carbon::parse($eventData['start_date']) : null;
        $endDate = isset($eventData['end_date']) ? Carbon::parse($eventData['end_date']) : null;

        // Extract location data
        $venue = $eventData['venue']['name'] ?? null;
        $address = $eventData['venue']['address'] ?? null;
        $city = $eventData['venue']['city'] ?? null;
        $country = $eventData['venue']['country'] ?? null;

        // Build location string
        $locationParts = array_filter([$address, $city, $country]);
        $location = ! empty($locationParts) ? implode(', ', $locationParts) : null;

        // Is virtual event?
        $isVirtual = $eventData['is_virtual'] ?? false;

        // Extract links
        $sourceUrl = $eventData['link'] ?? null;
        $ticketUrl = $eventData['ticket_url'] ?? null;

        // Determine event type based on title and description
        $eventType = $this->determineEventType($title, $description, $searchQuery);

        // Extract thumbnail/image
        $image = $eventData['thumbnail'] ?? null;

        return [
            'title' => $title,
            'description' => Str::limit($description, 500),
            'content' => $description,
            'image' => $image,
            'source' => 'OpenWebNinja',
            'source_url' => $sourceUrl,
            'external_id' => $this->generateExternalId($eventData),
            'event_type' => $eventType,
            'game_name' => null, // API doesn't provide this directly
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $location,
            'is_virtual' => $isVirtual,
            'venue' => $venue,
            'city' => $city,
            'country' => $country,
            'ticket_url' => $ticketUrl,
            'ticket_info' => null, // API doesn't provide detailed ticket info
            'organizer' => null, // API doesn't provide this
            'platform' => null,
            'tags' => null,
            'is_featured' => false,
            'is_published' => true,
            'views_count' => 0,
        ];
    }

    /**
     * Determine event type based on title, description, and search query.
     */
    protected function determineEventType(string $title, string $description, string $searchQuery): string
    {
        $combined = strtolower($title.' '.$description.' '.$searchQuery);

        if (Str::contains($combined, ['tournament', 'championship', 'competition', 'esports'])) {
            return 'tournament';
        }

        if (Str::contains($combined, ['expo', 'convention', 'conference', 'show'])) {
            return 'expo';
        }

        if (Str::contains($combined, ['launch', 'release', 'debut', 'premiere'])) {
            return 'release';
        }

        if (Str::contains($combined, ['update', 'patch', 'dlc', 'expansion'])) {
            return 'update';
        }

        return 'general';
    }
}
