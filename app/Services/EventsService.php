<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventImportedItem;
use App\Models\EventInfoLink;
use App\Models\EventTicketLink;
use App\Models\EventVenue;
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

                // The API response has 'data' as an array of events
                $eventsData = $apiResult['data']['data'] ?? [];

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
            // Use the API's event_id as the external ID
            $externalId = $eventData['event_id'] ?? null;

            if (! $externalId) {
                return [
                    'success' => false,
                    'skipped' => false,
                    'message' => 'Event has no event_id',
                ];
            }

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
            $eventRecord = $this->mapAndCreateEvent($eventData, $searchQuery);

            // Track import
            EventImportedItem::create([
                'source' => $source,
                'external_id' => $externalId,
                'event_id' => $eventRecord->id,
            ]);

            return [
                'success' => true,
                'skipped' => false,
                'message' => "Imported: {$eventRecord->name}",
            ];
        } catch (\Exception $e) {
            Log::error('Event processing error', [
                'event_data' => $eventData,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'skipped' => false,
                'message' => "Error processing event: {$e->getMessage()}",
            ];
        }
    }

    /**
     * Map and create event with all related records.
     */
    protected function mapAndCreateEvent(array $eventData, string $searchQuery): Event
    {
        // Extract core event data
        $name = $eventData['name'] ?? 'Untitled Event';
        $description = $eventData['description'] ?? '';

        // Parse dates
        $startTime = isset($eventData['start_time']) ? Carbon::parse($eventData['start_time']) : null;
        $startTimeUtc = isset($eventData['start_time_utc']) ? Carbon::parse($eventData['start_time_utc']) : null;
        $endTime = isset($eventData['end_time']) ? Carbon::parse($eventData['end_time']) : null;
        $endTimeUtc = isset($eventData['end_time_utc']) ? Carbon::parse($eventData['end_time_utc']) : null;

        // Determine event type based on name and description
        $eventType = $this->determineEventType($name, $description, $searchQuery);

        // Create the main event record
        $event = Event::create([
            'event_id' => $eventData['event_id'],
            'name' => $name,
            'link' => $eventData['link'] ?? null,
            'description' => $description,
            'language' => $eventData['language'] ?? null,
            'date_human_readable' => $eventData['date_human_readable'] ?? null,
            'start_time' => $startTime,
            'start_time_utc' => $startTimeUtc,
            'start_time_precision_sec' => $eventData['start_time_precision_sec'] ?? null,
            'end_time' => $endTime,
            'end_time_utc' => $endTimeUtc,
            'end_time_precision_sec' => $eventData['end_time_precision_sec'] ?? null,
            'is_virtual' => $eventData['is_virtual'] ?? false,
            'thumbnail' => $eventData['thumbnail'] ?? null,
            'publisher' => $eventData['publisher'] ?? null,
            'publisher_favicon' => $eventData['publisher_favicon'] ?? null,
            'publisher_domain' => $eventData['publisher_domain'] ?? null,
            'event_type' => $eventType,
            'is_featured' => false,
            'is_published' => true,
            'views_count' => 0,
        ]);

        // Process venue data if present
        if (isset($eventData['venue']) && is_array($eventData['venue'])) {
            $this->processVenue($event, $eventData['venue']);
        }

        // Process ticket links if present
        if (isset($eventData['ticket_links']) && is_array($eventData['ticket_links'])) {
            $this->processTicketLinks($event, $eventData['ticket_links']);
        }

        // Process info links if present
        if (isset($eventData['info_links']) && is_array($eventData['info_links'])) {
            $this->processInfoLinks($event, $eventData['info_links']);
        }

        return $event;
    }

    /**
     * Process and attach venue to event.
     */
    protected function processVenue(Event $event, array $venueData): void
    {
        $googleId = $venueData['google_id'] ?? null;

        // Try to find existing venue by google_id, or fallback to name/address if missing
        if ($googleId) {
            $venue = EventVenue::where('google_id', $googleId)->first();
        } else {
            // Fallback: try to find by name and full_address (or name + city if full_address missing)
            $venue = null;
            if (! empty($venueData['name'])) {
                $venueQuery = EventVenue::query()->where('name', $venueData['name']);

                if (! empty($venueData['full_address'])) {
                    $venueQuery->where('full_address', $venueData['full_address']);
                } elseif (! empty($venueData['city'])) {
                    $venueQuery->where('city', $venueData['city']);
                }

                $venue = $venueQuery->first();
            }
        }

        // Create or update venue
        if (! $venue) {
            $venue = EventVenue::create([
                'google_id' => $googleId,
                'name' => $venueData['name'] ?? 'Unknown Venue',
                'phone_number' => $venueData['phone_number'] ?? null,
                'website' => $venueData['website'] ?? null,
                'review_count' => $venueData['review_count'] ?? null,
                'rating' => $venueData['rating'] ?? null,
                'subtype' => $venueData['subtype'] ?? null,
                'subtypes' => $venueData['subtypes'] ?? null,
                'full_address' => $venueData['full_address'] ?? null,
                'latitude' => $venueData['latitude'] ?? null,
                'longitude' => $venueData['longitude'] ?? null,
                'district' => $venueData['district'] ?? null,
                'street_number' => $venueData['street_number'] ?? null,
                'street' => $venueData['street'] ?? null,
                'city' => $venueData['city'] ?? null,
                'zipcode' => $venueData['zipcode'] ?? null,
                'state' => $venueData['state'] ?? null,
                'country' => $venueData['country'] ?? null,
                'timezone' => $venueData['timezone'] ?? null,
                'google_mid' => $venueData['google_mid'] ?? null,
            ]);
        }

        // Attach venue to event
        $event->venues()->attach($venue->id);
    }

    /**
     * Process and create ticket links for event.
     */
    protected function processTicketLinks(Event $event, array $ticketLinks): void
    {
        foreach ($ticketLinks as $link) {
            if (empty($link['link'])) {
                Log::warning('Skipping EventTicketLink creation: missing or empty link.', [
                    'event_id' => $event->id,
                    'ticket_link_data' => $link,
                ]);

                continue;
            }

            EventTicketLink::create([
                'event_id' => $event->id,
                'source' => $link['source'] ?? 'Unknown',
                'link' => $link['link'],
                'fav_icon' => $link['fav_icon'] ?? null,
            ]);
        }
    }

    /**
     * Process and create info links for event.
     */
    protected function processInfoLinks(Event $event, array $infoLinks): void
    {
        foreach ($infoLinks as $link) {
            if (empty($link['link'])) {
                Log::warning('Skipping EventInfoLink creation: missing or empty link.', [
                    'event_id' => $event->id,
                    'info_link_data' => $link,
                ]);

                continue;
            }

            EventInfoLink::create([
                'event_id' => $event->id,
                'source' => $link['source'] ?? 'Unknown',
                'link' => $link['link'],
            ]);
        }
    }

    /**
     * Determine event type based on name, description, and search query.
     */
    protected function determineEventType(string $name, string $description, string $searchQuery): string
    {
        $combined = strtolower($name.' '.$description.' '.$searchQuery);

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
