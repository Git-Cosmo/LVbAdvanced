<?php

namespace App\Console\Commands;

use App\Services\RedditScraperService;
use Illuminate\Console\Command;

class RedditScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reddit:scrape {subreddit?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape Reddit posts from configured subreddits';

    /**
     * Execute the console command.
     */
    public function handle(RedditScraperService $scraper)
    {
        $subreddit = $this->argument('subreddit');

        $this->info('Starting Reddit scrape...');

        if ($subreddit) {
            $this->info("Scraping r/{$subreddit}...");
            $count = $scraper->scrapeSubreddit($subreddit, 25);
            $this->info("Imported {$count} posts from r/{$subreddit}");
        } else {
            $this->info('Scraping all enabled subreddits...');
            $results = $scraper->scrapeAll();

            foreach ($results as $sub => $count) {
                $this->info("r/{$sub}: {$count} posts imported");
            }

            $total = array_sum($results);
            $this->info("Total: {$total} posts imported");
        }

        $this->info('Scrape complete!');
        return 0;
    }
}
