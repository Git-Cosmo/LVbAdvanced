<?php

namespace App\Http\Controllers;

use App\Models\CheapSharkDeal;
use App\Models\Event;
use App\Models\Forum\ForumThread;
use App\Models\News;
use App\Models\User\Gallery;
use App\Services\AzuracastService;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function home(AzuracastService $azuracast): View
    {
        try {
            $payload = $azuracast->nowPlaying();
        } catch (\Exception $e) {
            // Gracefully handle AzuraCast connection failures
            $payload = [
                'now_playing' => null,
                'playing_next' => null,
                'song_history' => [],
                'is_online' => false,
            ];
        }

        // Get real data for homepage
        $latestNews = News::published()
            ->with('user')
            ->latest('published_at')
            ->take(5)
            ->get();

        $latestDeals = CheapSharkDeal::with('game', 'store')
            ->where('on_sale', true)
            ->orderBy('savings', 'desc')
            ->take(4)
            ->get();

        $latestDownloads = Gallery::with(['user', 'galleryMedia'])
            ->latest()
            ->take(4)
            ->get();

        $recentThreads = ForumThread::with(['user', 'forum'])
            ->where('is_hidden', false)
            ->latest('last_post_at')
            ->take(5)
            ->get();

        // Get upcoming events
        $upcomingEvents = Event::where('is_published', true)
            ->where('start_time', '>', now())
            ->orderBy('start_time', 'asc')
            ->take(3)
            ->get();

        return view('portal.home', [
            'nowPlaying' => $payload['now_playing'] ?? null,
            'upNext' => $payload['playing_next'] ?? null,
            'recentSongs' => array_slice($payload['song_history'] ?? [], 0, 3),
            'stationOnline' => $payload['is_online'] ?? false,
            'latestNews' => $latestNews,
            'latestDeals' => $latestDeals,
            'latestDownloads' => $latestDownloads,
            'recentThreads' => $recentThreads,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
