<?php

namespace App\Console\Commands;

use App\Services\EventsService;
use Illuminate\Console\Command;

class ImportEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import gaming events from various public sources';

    /**
     * Execute the console command.
     */
    public function handle(EventsService $eventsService)
    {
        $this->info('Starting events import from OpenWebNinja API...');

        $results = $eventsService->importEvents();

        $this->line('');
        $this->info('Import Summary:');
        $this->line("  ✓ Successfully imported: {$results['success']}");
        $this->line("  ⊘ Skipped (already exists): {$results['skipped']}");
        $this->line("  ✗ Errors: {$results['errors']}");

        if ($results['errors'] > 0) {
            $this->warn('Some errors occurred during import. Check the logs for details or run this command with -v for verbose output.');
        }

        if (!empty($results['messages']) && $this->output->isVerbose()) {
            $this->line('');
            $this->line('Details:');
            foreach ($results['messages'] as $message) {
                $this->line("  - {$message}");
            }
        }

        $this->info('Events import completed!');

        return Command::SUCCESS;
    }
}
