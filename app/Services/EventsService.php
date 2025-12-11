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
     * Seed major gaming conventions and events.
     * This method populates the database with major gaming events that don't change frequently.
     */
    public function seedMajorGamingEvents(): array
    {
        $results = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];

        // Define major gaming events for 2025-2026
        $majorEvents = $this->getMajorGamingEvents();

        foreach ($majorEvents as $eventData) {
            try {
                $externalId = $eventData['external_id'];
                $source = 'major_events_seed';

                // Check if already imported
                if (EventImportedItem::where('source', $source)
                    ->where('external_id', $externalId)
                    ->exists()) {
                    $results['skipped']++;
                    continue;
                }

                // Create event
                $event = Event::create($eventData);

                // Track import
                EventImportedItem::create([
                    'source' => $source,
                    'external_id' => $externalId,
                    'event_id' => $event->id,
                ]);

                $results['success']++;
                $results['messages'][] = "Seeded: {$event->title}";
            } catch (\Exception $e) {
                $results['errors']++;
                $results['messages'][] = "Error seeding event: {$e->getMessage()}";
                Log::error('Event seeding error', ['error' => $e->getMessage(), 'event' => $eventData['title'] ?? 'Unknown']);
            }
        }

        return $results;
    }

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

        // First, seed major gaming events if not already done
        try {
            $seedResults = $this->seedMajorGamingEvents();
            $results['success'] += $seedResults['success'];
            $results['skipped'] += $seedResults['skipped'];
            $results['errors'] += $seedResults['errors'];
            $results['messages'] = array_merge($results['messages'], $seedResults['messages']);
        } catch (\Exception $e) {
            $results['errors']++;
            $results['messages'][] = "Seeding error: {$e->getMessage()}";
            Log::error('Event seeding error', ['error' => $e->getMessage()]);
        }

        // Try to scrape from Liquipedia esports events
        try {
            $liquipediaResults = $this->scrapeLiquipediaEvents();
            $results['success'] += $liquipediaResults['success'];
            $results['skipped'] += $liquipediaResults['skipped'];
            $results['errors'] += $liquipediaResults['errors'];
            $results['messages'] = array_merge($results['messages'], $liquipediaResults['messages']);
        } catch (\Exception $e) {
            $results['errors']++;
            $results['messages'][] = "Liquipedia scraping error: {$e->getMessage()}";
            Log::error('Liquipedia events scraping error', ['error' => $e->getMessage()]);
        }

        return $results;
    }

    /**
     * Get major gaming events data.
     */
    protected function getMajorGamingEvents(): array
    {
        return [
            [
                'external_id' => 'super-magfest-2026',
                'title' => 'Super MAGFest 2026',
                'description' => 'Music and Gaming Festival - A celebration of video games and video game music.',
                'content' => 'Super MAGFest (Music and Gaming Festival) is a four-day festival of video games and video game music held annually. It features concerts, video game tournaments, panels, and more.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-01-08'),
                'end_date' => Carbon::parse('2026-01-11'),
                'location' => 'National Harbor, MD',
                'venue' => 'Gaylord National Resort & Convention Center',
                'city' => 'National Harbor',
                'country' => 'USA',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://super.magfest.org/',
                'ticket_url' => 'https://super.magfest.org/attendee-information',
                'ticket_info' => 'Badge prices vary by registration date. Early registration typically starts at $65 for a full weekend pass.',
                'organizer' => 'MAGFest Inc.',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'taipei-game-show-2026',
                'title' => 'Taipei Game Show 2026',
                'description' => 'Asia\'s premier gaming event featuring game publishers, developers, and gamers from around the world.',
                'content' => 'Taipei Game Show is one of the largest gaming events in Asia, featuring exhibitions from major game publishers, indie developers, esports tournaments, and business matching opportunities.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-01-23'),
                'end_date' => Carbon::parse('2026-01-26'),
                'location' => 'Taipei, Taiwan',
                'venue' => 'Taipei Nangang Exhibition Center',
                'city' => 'Taipei',
                'country' => 'Taiwan',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://tgs.tca.org.tw/',
                'ticket_url' => 'https://tgs.tca.org.tw/ticket',
                'ticket_info' => 'Standard admission tickets available online. VIP passes and business passes also available.',
                'organizer' => 'Taipei Computer Association',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'pax-east-2026',
                'title' => 'PAX East 2026',
                'description' => 'Penny Arcade Expo - The ultimate gaming festival for fans and creators.',
                'content' => 'PAX East is a celebration of gaming culture featuring tabletop games, video games, panels, concerts, and the opportunity to play upcoming releases before they hit the market.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-03-26'),
                'end_date' => Carbon::parse('2026-03-29'),
                'location' => 'Boston, MA',
                'venue' => 'Boston Convention and Exhibition Center',
                'city' => 'Boston',
                'country' => 'USA',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://east.paxsite.com/',
                'ticket_url' => 'https://east.paxsite.com/badges',
                'ticket_info' => 'Single-day and multi-day badges available. Badges typically sell out quickly.',
                'organizer' => 'ReedPop',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'gdc-2026',
                'title' => 'Game Developers Conference (GDC) 2026',
                'description' => 'The world\'s largest professional game industry event.',
                'content' => 'GDC is the premier professional event for game developers, featuring technical sessions, tutorials, panels, and networking opportunities. It\'s where the game development community comes together to learn, network, and be inspired.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-03-16'),
                'end_date' => Carbon::parse('2026-03-20'),
                'location' => 'San Francisco, CA',
                'venue' => 'Moscone Convention Center',
                'city' => 'San Francisco',
                'country' => 'USA',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://gdconf.com/',
                'ticket_url' => 'https://gdconf.com/passes-prices',
                'ticket_info' => 'Multiple pass types available from Expo Pass ($199) to All-Access Pass ($2,099+). Early bird discounts available.',
                'organizer' => 'Informa Tech',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'reboot-develop-blue-2026',
                'title' => 'Reboot Develop Blue 2026',
                'description' => 'Premium game developer conference on the Adriatic coast.',
                'content' => 'Reboot Develop Blue is a boutique developer conference bringing together some of the industry\'s most talented and experienced individuals in a relaxed and inspiring environment.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-04-20'),
                'end_date' => Carbon::parse('2026-04-22'),
                'location' => 'Dubrovnik, Croatia',
                'venue' => 'Hotel Dubrovnik Palace',
                'city' => 'Dubrovnik',
                'country' => 'Croatia',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://rebootdevelop.com/',
                'ticket_url' => 'https://rebootdevelop.com/tickets',
                'ticket_info' => 'Professional developer passes available. Limited capacity event.',
                'organizer' => 'Reboot InfoGamer',
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'external_id' => 'e3-2026',
                'title' => 'E3 2026 (Electronic Entertainment Expo)',
                'description' => 'The world\'s premier event for video games and related products.',
                'content' => 'E3 is the world\'s premier trade show for video games and related products. The event is known for its major announcements and game reveals from leading publishers.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-06-09'),
                'end_date' => Carbon::parse('2026-06-11'),
                'location' => 'Los Angeles, CA',
                'venue' => 'Los Angeles Convention Center',
                'city' => 'Los Angeles',
                'country' => 'USA',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://www.e3expo.com/',
                'ticket_url' => 'https://www.e3expo.com/tickets',
                'ticket_info' => 'Industry and media badges required. Public tickets may be available.',
                'organizer' => 'Entertainment Software Association (ESA)',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'gamescom-2026',
                'title' => 'gamescom 2026',
                'description' => 'The world\'s largest gaming event and Europe\'s leading trade fair.',
                'content' => 'gamescom is the world\'s largest gaming event, featuring the latest games, gaming hardware, and esports tournaments. It combines a trade fair for industry professionals with a festival for gaming fans.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-08-26'),
                'end_date' => Carbon::parse('2026-08-30'),
                'location' => 'Cologne, Germany',
                'venue' => 'Koelnmesse',
                'city' => 'Cologne',
                'country' => 'Germany',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://www.gamescom.global/',
                'ticket_url' => 'https://www.gamescom.global/tickets',
                'ticket_info' => 'Day tickets and multi-day tickets available. Prices vary by day and ticket type.',
                'organizer' => 'Koelnmesse & game - Verband der deutschen Games-Branche',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'pax-west-2026',
                'title' => 'PAX West 2026',
                'description' => 'Seattle\'s celebration of gaming culture and community.',
                'content' => 'PAX West is the original PAX event, celebrating gaming in all its forms including console, PC, tabletop, and more. Features game demos, tournaments, panels, and community events.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-09-04'),
                'end_date' => Carbon::parse('2026-09-07'),
                'location' => 'Seattle, WA',
                'venue' => 'Washington State Convention Center',
                'city' => 'Seattle',
                'country' => 'USA',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://west.paxsite.com/',
                'ticket_url' => 'https://west.paxsite.com/badges',
                'ticket_info' => 'Single-day and multi-day badges available. Typically sell out within hours of going on sale.',
                'organizer' => 'ReedPop',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'tokyo-game-show-2026',
                'title' => 'Tokyo Game Show 2026',
                'description' => 'Japan\'s premier gaming event and one of the world\'s largest.',
                'content' => 'Tokyo Game Show is one of the world\'s largest gaming events, showcasing the latest in Japanese and international gaming. Features new game announcements, playable demos, and esports tournaments.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-09-24'),
                'end_date' => Carbon::parse('2026-09-27'),
                'location' => 'Chiba, Japan',
                'venue' => 'Makuhari Messe',
                'city' => 'Chiba',
                'country' => 'Japan',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://tgs.nikkeibp.co.jp/',
                'ticket_url' => 'https://tgs.nikkeibp.co.jp/en/ticket',
                'ticket_info' => 'Day tickets available online. Business days require industry credentials.',
                'organizer' => 'Computer Entertainment Supplier\'s Association (CESA)',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'external_id' => 'pax-aus-2026',
                'title' => 'PAX Australia 2026',
                'description' => 'Australia\'s biggest celebration of gaming culture.',
                'content' => 'PAX Australia brings the PAX experience Down Under, featuring the latest games, tabletop gaming, panels with industry professionals, and a vibrant community atmosphere.',
                'event_type' => 'expo',
                'start_date' => Carbon::parse('2026-10-09'),
                'end_date' => Carbon::parse('2026-10-11'),
                'location' => 'Melbourne, Australia',
                'venue' => 'Melbourne Convention and Exhibition Centre',
                'city' => 'Melbourne',
                'country' => 'Australia',
                'source' => 'Major Gaming Events',
                'source_url' => 'https://aus.paxsite.com/',
                'ticket_url' => 'https://aus.paxsite.com/badges',
                'ticket_info' => 'Three-day and single-day badges available.',
                'organizer' => 'ReedPop',
                'is_published' => true,
                'is_featured' => false,
            ],
        ];
    }

    /**
     * Scrape esports tournaments from Liquipedia.
     * Note: This is a placeholder for potential future implementation.
     * Liquipedia scraping requires respecting their terms of service and rate limits.
     */
    protected function scrapeLiquipediaEvents(): array
    {
        $results = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];
        
        // For now, we only seed major events
        // Future: Can add scraping from esports tournament APIs like Abios, PandaScore (require API keys)
        // or parse from public calendars if available
        
        $results['messages'][] = "Liquipedia scraping not yet implemented. Using seeded major events only.";
        
        return $results;
    }
}
