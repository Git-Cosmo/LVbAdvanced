<?php

namespace App\Http\Controllers;

use App\Models\Streamer;
use App\Services\KickApiService;
use App\Services\TwitchApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StreamerController extends Controller
{
    public function index(Request $request)
    {
        $platform = $request->get('platform', 'all');

        $query = Streamer::live();

        if ($platform !== 'all') {
            $query->byPlatform($platform);
        }

        $streamers = $query->topViewers(50)->get();

        // Group by platform for display
        $twitchStreamers = $streamers->where('platform', 'twitch');
        $kickStreamers = $streamers->where('platform', 'kick');

        return view('streamers.index', [
            'streamers' => $streamers,
            'twitchStreamers' => $twitchStreamers,
            'kickStreamers' => $kickStreamers,
            'platform' => $platform,
            'page' => (object) [
                'title' => 'Live Streamers - FPSociety',
                'meta_title' => 'Top Live Streamers on Twitch & Kick | FPSociety',
                'meta_description' => 'Watch the top gaming streamers currently live on Twitch and Kick. Find your favorite content creators and discover new channels.',
            ],
        ]);
    }

    public function sync(TwitchApiService $twitchApi, KickApiService $kickApi)
    {
        // Admin only
        if (!auth()->user() || !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $twitchSynced = $twitchApi->syncTopStreamers(20);
        $kickSynced = $kickApi->syncTopStreamers(20);

        return back()->with('success', "Synced {$twitchSynced} Twitch and {$kickSynced} Kick streamers!");
    }
}
