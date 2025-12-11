<?php

namespace App\Console\Commands;

use App\Services\StreamerBansScraperService;
use Illuminate\Console\Command;

class StreamerBansScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'streamerbans:scrape {username?} {--update : Update existing streamers} {--limit= : Limit number of streamers to update}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape streamer ban data from streamerbans.com';

    /**
     * Execute the console command.
     */
    public function handle(StreamerBansScraperService $scraper)
    {
        $username = $this->argument('username');
        $update = $this->option('update');
        $limit = $this->option('limit');

        $this->info('Starting StreamerBans scraper...');

        if ($username) {
            // Scrape a specific streamer
            $this->info("Scraping data for {$username}...");
            $success = $scraper->scrapeStreamer($username);
            
            if ($success) {
                $this->info("✓ Successfully scraped and saved data for {$username}");
            } else {
                $this->error("✗ Failed to scrape data for {$username}");
            }
        } elseif ($update) {
            // Update existing streamers
            $this->info('Updating existing streamers...');
            if ($limit) {
                $this->info("Limiting to {$limit} streamers");
            }
            
            $results = $scraper->updateExistingStreamers($limit ? (int) $limit : null);
            
            $this->info("Update complete:");
            $this->info("  Total: {$results['total']}");
            $this->info("  Success: {$results['success']}");
            $this->info("  Failed: {$results['failed']}");
        } else {
            // Scrape all streamers from the main page
            $this->info('Scraping all streamers from streamerbans.com...');
            $results = $scraper->scrapeAll();
            
            $this->info("Scraping complete:");
            $this->info("  Total streamers found: {$results['total']}");
            $this->info("  Successfully scraped: {$results['success']}");
            $this->info("  Failed: {$results['failed']}");
        }

        $this->info('Done!');
        return Command::SUCCESS;
    }
}
