<?php

namespace Database\Seeders;

use App\Models\RssFeed;
use Illuminate\Database\Seeder;

class RssFeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feeds = [
            [
                'name' => 'IGN - Gaming News',
                'url' => 'https://feeds.feedburner.com/ign/games-all',
                'refresh_interval' => 30,
                'settings' => [
                    'tags' => ['ign', 'news', 'gaming'],
                ],
            ],
            [
                'name' => 'GameSpot News',
                'url' => 'https://www.gamespot.com/feeds/news/',
                'refresh_interval' => 30,
                'settings' => [
                    'tags' => ['gamespot', 'news', 'reviews'],
                ],
            ],
            [
                'name' => 'Polygon',
                'url' => 'https://www.polygon.com/rss/index.xml',
                'refresh_interval' => 45,
                'settings' => [
                    'tags' => ['polygon', 'culture', 'features'],
                ],
            ],
            [
                'name' => 'Eurogamer',
                'url' => 'https://www.eurogamer.net/rss',
                'refresh_interval' => 45,
                'settings' => [
                    'tags' => ['eurogamer', 'updates', 'hardware'],
                ],
            ],
            [
                'name' => 'PC Gamer',
                'url' => 'https://www.pcgamer.com/rss/',
                'refresh_interval' => 30,
                'settings' => [
                    'tags' => ['pc-gamer', 'pc', 'hardware'],
                ],
            ],
            [
                'name' => 'Kotaku',
                'url' => 'https://kotaku.com/rss',
                'refresh_interval' => 60,
                'settings' => [
                    'tags' => ['kotaku', 'opinion', 'news'],
                ],
            ],
            [
                'name' => 'Game Informer',
                'url' => 'https://www.gameinformer.com/rss',
                'refresh_interval' => 45,
                'settings' => [
                    'tags' => ['game-informer', 'previews', 'marketing'],
                ],
            ],
            [
                'name' => 'Nintendo News',
                'url' => 'https://www.nintendo.com/rss.xml',
                'refresh_interval' => 60,
                'settings' => [
                    'tags' => ['nintendo', 'console', 'first-party'],
                ],
            ],
        ];

        foreach ($feeds as $feed) {
            RssFeed::updateOrCreate(
                ['url' => $feed['url']],
                [
                    'name' => $feed['name'],
                    'refresh_interval' => $feed['refresh_interval'],
                    'is_active' => true,
                    'settings' => $feed['settings'],
                ]
            );
        }
    }
}
