<?php

namespace App\Console\Commands;

use App\Services\KickApiService;
use App\Services\TwitchApiService;
use Illuminate\Console\Command;

class SyncStreamersCommand extends Command
{
    protected $signature = 'streamers:sync {--limit=20 : Number of streamers to sync per platform}';

    protected $description = 'Sync top live streamers from Twitch and Kick';

    public function handle(TwitchApiService $twitchApi, KickApiService $kickApi)
    {
        $limit = (int) $this->option('limit');

        $this->info('Syncing Twitch streamers...');
        $twitchSynced = $twitchApi->syncTopStreamers($limit);
        $this->info("Synced {$twitchSynced} Twitch streamers.");

        $this->info('Syncing Kick streamers...');
        $kickSynced = $kickApi->syncTopStreamers($limit);
        $this->info("Synced {$kickSynced} Kick streamers.");

        $this->info("Total synced: ".($twitchSynced + $kickSynced).' streamers.');

        return Command::SUCCESS;
    }
}
