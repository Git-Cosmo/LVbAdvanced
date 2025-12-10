<?php

namespace App\Console\Commands;

use App\Services\RssFeedService;
use Illuminate\Console\Command;

class ImportRssFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:import {--feed= : Import specific feed ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import news articles from RSS feeds';

    /**
     * Execute the console command.
     */
    public function handle(RssFeedService $rssFeedService)
    {
        $this->info('Starting RSS feed import...');

        if ($feedId = $this->option('feed')) {
            $feed = \App\Models\RssFeed::findOrFail($feedId);
            $results = $rssFeedService->importFeed($feed);
            $this->displayResults($feed->name, $results);
        } else {
            $results = $rssFeedService->importAllFeeds();
            $this->displayResults('All Feeds', $results);
        }

        $this->info('RSS import completed!');
        
        return Command::SUCCESS;
    }

    /**
     * Display import results.
     */
    protected function displayResults(string $feedName, array $results): void
    {
        $this->line('');
        $this->info("Feed: {$feedName}");
        $this->line("  ✓ Successfully imported: {$results['success']}");
        $this->line("  ⊘ Skipped (already exists): {$results['skipped']}");
        $this->line("  ✗ Errors: {$results['errors']}");
        
        if (!empty($results['messages']) && $this->output->isVerbose()) {
            $this->line('');
            $this->line('Details:');
            foreach ($results['messages'] as $message) {
                $this->line("  - {$message}");
            }
        }
    }
}
