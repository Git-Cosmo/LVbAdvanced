<?php

namespace App\Console\Commands;

use App\Services\PatchNotesScraperService;
use Illuminate\Console\Command;

class ScrapePatchNotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patch-notes:scrape 
                            {--game= : Specific game to scrape}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape patch notes from various gaming sources';

    /**
     * Execute the console command.
     */
    public function handle(PatchNotesScraperService $scraper): int
    {
        $this->info('Starting patch notes scraper...');

        $startTime = microtime(true);
        
        try {
            $results = $scraper->scrapeAll();
            
            $totalScraped = array_sum($results);
            
            $this->newLine();
            $this->info('Scraping complete!');
            $this->newLine();
            
            // Display results
            $this->table(
                ['Game', 'Patch Notes Found'],
                collect($results)->map(function ($count, $game) {
                    return [$game, $count];
                })->toArray()
            );
            
            $this->newLine();
            $this->info("Total patch notes scraped: {$totalScraped}");
            
            $duration = round(microtime(true) - $startTime, 2);
            $this->info("Time taken: {$duration} seconds");
            
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Scraping failed: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            
            return self::FAILURE;
        }
    }
}
