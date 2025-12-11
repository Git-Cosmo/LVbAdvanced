<?php

namespace Database\Seeders;

use App\Models\RedditSubreddit;
use Illuminate\Database\Seeder;

class RedditSubredditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subreddits = [
            [
                'name' => 'LivestreamFail',
                'display_name' => 'r/LivestreamFail',
                'is_enabled' => true,
                'content_type' => 'video',
                'scrape_limit' => 25,
            ],
            [
                'name' => 'AITAH',
                'display_name' => 'r/AITAH',
                'is_enabled' => true,
                'content_type' => 'text',
                'scrape_limit' => 25,
            ],
        ];

        foreach ($subreddits as $subreddit) {
            RedditSubreddit::updateOrCreate(
                ['name' => $subreddit['name']],
                $subreddit
            );
        }
    }
}
