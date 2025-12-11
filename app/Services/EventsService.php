<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventImportedItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EventsService
{
    /**
     * Scrape events from various public gaming sources.
     */
    public function scrapeEvents(): array
    {
        $results = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];

        // Source 1: GameSpot Gaming Events RSS
        try {
            $gameSpotResults = $this->scrapeGameSpotEvents();
            $results['success'] += $gameSpotResults['success'];
            $results['skipped'] += $gameSpotResults['skipped'];
            $results['errors'] += $gameSpotResults['errors'];
            $results['messages'] = array_merge($results['messages'], $gameSpotResults['messages']);
        } catch (\Exception $e) {
            $results['errors']++;
            $results['messages'][] = "GameSpot scraping error: {$e->getMessage()}";
            Log::error('GameSpot events scraping error', ['error' => $e->getMessage()]);
        }

        // Source 2: IGN Gaming Events RSS
        try {
            $ignResults = $this->scrapeIGNEvents();
            $results['success'] += $ignResults['success'];
            $results['skipped'] += $ignResults['skipped'];
            $results['errors'] += $ignResults['errors'];
            $results['messages'] = array_merge($results['messages'], $ignResults['messages']);
        } catch (\Exception $e) {
            $results['errors']++;
            $results['messages'][] = "IGN scraping error: {$e->getMessage()}";
            Log::error('IGN events scraping error', ['error' => $e->getMessage()]);
        }

        return $results;
    }

    /**
     * Scrape gaming events from GameSpot RSS feed.
     */
    protected function scrapeGameSpotEvents(): array
    {
        $results = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];

        $feedUrl = 'https://www.gamespot.com/feeds/news/';
        $source = 'gamespot';

        try {
            $items = $this->fetchRSSFeed($feedUrl);

            foreach ($items as $item) {
                try {
                    $externalId = $this->getElementText($item, 'guid') ?: $this->getElementText($item, 'link');
                    
                    if (!$externalId) {
                        continue;
                    }

                    // Check if already imported
                    if (EventImportedItem::where('source', $source)
                        ->where('external_id', $externalId)
                        ->exists()) {
                        $results['skipped']++;
                        continue;
                    }

                    // Parse event data
                    $title = $this->getElementText($item, 'title');
                    $description = $this->getElementText($item, 'description');
                    $link = $this->getElementText($item, 'link');
                    $pubDate = $this->parseDate($this->getElementText($item, 'pubDate'));
                    $image = $this->resolveImageUrl($item);

                    // Create event
                    $event = Event::create([
                        'title' => $title ?: 'Untitled Event',
                        'description' => strip_tags($description),
                        'content' => $description,
                        'image' => $image,
                        'source' => 'GameSpot',
                        'source_url' => $link,
                        'external_id' => $externalId,
                        'event_type' => $this->detectEventType($title),
                        'start_date' => $pubDate,
                        'is_published' => true,
                        'is_featured' => false,
                    ]);

                    // Track import
                    EventImportedItem::create([
                        'source' => $source,
                        'external_id' => $externalId,
                        'event_id' => $event->id,
                    ]);

                    $results['success']++;
                    $results['messages'][] = "Imported: {$event->title}";
                } catch (\Exception $e) {
                    $results['errors']++;
                    $results['messages'][] = "Error importing GameSpot item: {$e->getMessage()}";
                    Log::error('GameSpot item import error', ['error' => $e->getMessage()]);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $results;
    }

    /**
     * Scrape gaming events from IGN RSS feed.
     */
    protected function scrapeIGNEvents(): array
    {
        $results = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];

        $feedUrl = 'https://feeds.ign.com/ign/all';
        $source = 'ign';

        try {
            $items = $this->fetchRSSFeed($feedUrl);

            foreach ($items as $item) {
                try {
                    $externalId = $this->getElementText($item, 'guid') ?: $this->getElementText($item, 'link');
                    
                    if (!$externalId) {
                        continue;
                    }

                    // Check if already imported
                    if (EventImportedItem::where('source', $source)
                        ->where('external_id', $externalId)
                        ->exists()) {
                        $results['skipped']++;
                        continue;
                    }

                    // Parse event data
                    $title = $this->getElementText($item, 'title');
                    $description = $this->getElementText($item, 'description');
                    $link = $this->getElementText($item, 'link');
                    $pubDate = $this->parseDate($this->getElementText($item, 'pubDate'));
                    $image = $this->resolveImageUrl($item);

                    // Create event
                    $event = Event::create([
                        'title' => $title ?: 'Untitled Event',
                        'description' => strip_tags($description),
                        'content' => $description,
                        'image' => $image,
                        'source' => 'IGN',
                        'source_url' => $link,
                        'external_id' => $externalId,
                        'event_type' => $this->detectEventType($title),
                        'start_date' => $pubDate,
                        'is_published' => true,
                        'is_featured' => false,
                    ]);

                    // Track import
                    EventImportedItem::create([
                        'source' => $source,
                        'external_id' => $externalId,
                        'event_id' => $event->id,
                    ]);

                    $results['success']++;
                    $results['messages'][] = "Imported: {$event->title}";
                } catch (\Exception $e) {
                    $results['errors']++;
                    $results['messages'][] = "Error importing IGN item: {$e->getMessage()}";
                    Log::error('IGN item import error', ['error' => $e->getMessage()]);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $results;
    }

    /**
     * Fetch RSS feed and parse items.
     */
    protected function fetchRSSFeed(string $url): array
    {
        $userAgent = config('app.name', 'Laravel') . ' Events Scraper';
        
        $response = Http::timeout(30)
            ->withHeaders(['User-Agent' => $userAgent])
            ->get($url);

        if ($response->failed()) {
            throw new \Exception(sprintf('HTTP %s fetching %s', $response->status(), $url));
        }

        libxml_use_internal_errors(true);
        // Use secure XML loading options to prevent XXE attacks
        $xml = simplexml_load_string(
            $response->body(),
            \SimpleXMLElement::class,
            LIBXML_NOCDATA | LIBXML_NONET | LIBXML_NOBLANKS
        );

        if (!$xml) {
            $errors = libxml_get_errors();
            $messages = array_map(fn($error) => trim($error->message), $errors);
            libxml_clear_errors();
            throw new \Exception('Unable to parse RSS feed XML: ' . implode('; ', array_filter($messages)));
        }

        $items = [];

        if (isset($xml->channel->item)) {
            foreach ($xml->channel->item as $item) {
                $items[] = $item;
            }
        } elseif (isset($xml->item)) {
            foreach ($xml->item as $item) {
                $items[] = $item;
            }
        }

        libxml_clear_errors();
        return $items;
    }

    /**
     * Get text content from XML element.
     */
    protected function getElementText(\SimpleXMLElement $item, string $key): ?string
    {
        if (strpos($key, ':') === false) {
            return isset($item->{$key}) ? trim((string) $item->{$key}) : null;
        }

        [$prefix, $local] = explode(':', $key, 2);
        $namespaces = $item->getNamespaces(true);

        if (!isset($namespaces[$prefix])) {
            return null;
        }

        $child = $item->children($namespaces[$prefix])->{$local};

        return $child ? trim((string) $child) : null;
    }

    /**
     * Parse date string to Carbon instance.
     * Falls back to current time if parsing fails (for RSS items without proper dates).
     */
    protected function parseDate(?string $value): Carbon
    {
        if (!$value) {
            // Use current time as fallback for events without dates
            // This ensures events are still imported but marked as current
            return now();
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            Log::warning('Unable to parse event date, using current time as fallback', ['value' => $value]);
            return now();
        }
    }

    /**
     * Resolve image URL from RSS item.
     */
    protected function resolveImageUrl(\SimpleXMLElement $item): ?string
    {
        // Check for enclosure
        if (isset($item->enclosure)) {
            $url = (string) $item->enclosure['url'];
            if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
                return $url;
            }
        }

        // Check for media:content
        $media = $item->children('http://search.yahoo.com/mrss/');
        if (isset($media->content)) {
            $attributes = $media->content->attributes();
            if (isset($attributes['url'])) {
                $url = (string) $attributes['url'];
                if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
                    return $url;
                }
            }
        }

        // Check for media:thumbnail
        if (isset($media->thumbnail)) {
            $attributes = $media->thumbnail->attributes();
            if (isset($attributes['url'])) {
                $url = (string) $attributes['url'];
                if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
                    return $url;
                }
            }
        }

        return null;
    }

    /**
     * Detect event type from title.
     */
    protected function detectEventType(string $title): string
    {
        $title = strtolower($title);

        if (preg_match('/\b(release|launch|coming|out now)\b/', $title)) {
            return 'release';
        }

        if (preg_match('/\b(tournament|competition|championship|esports)\b/', $title)) {
            return 'tournament';
        }

        if (preg_match('/\b(expo|convention|e3|gamescom|pax)\b/', $title)) {
            return 'expo';
        }

        if (preg_match('/\b(update|patch|dlc|expansion)\b/', $title)) {
            return 'update';
        }

        return 'general';
    }
}
