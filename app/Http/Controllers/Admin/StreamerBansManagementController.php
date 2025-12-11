<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StreamerBan;
use App\Services\StreamerBansScraperService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StreamerBansManagementController extends Controller
{
    /**
     * Display StreamerBans management dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_streamers' => StreamerBan::count(),
            'published_streamers' => StreamerBan::where('is_published', true)->count(),
            'featured_streamers' => StreamerBan::where('is_featured', true)->count(),
            'total_bans_tracked' => StreamerBan::sum('total_bans'),
        ];

        $recentStreamers = StreamerBan::orderBy('last_scraped_at', 'desc')
            ->take(20)
            ->get();

        $mostBanned = StreamerBan::mostBanned()
            ->take(10)
            ->get();

        return view('admin.streamerbans.index', compact('stats', 'recentStreamers', 'mostBanned'));
    }

    /**
     * Trigger manual StreamerBans scrape.
     */
    public function scrape(Request $request, StreamerBansScraperService $scraper)
    {
        try {
            $action = $request->input('action', 'all');
            
            if ($action === 'update') {
                // Update existing streamers
                $limit = $request->input('limit', 50);
                $results = $scraper->updateExistingStreamers((int) $limit);
                $message = "Successfully updated {$results['success']} streamers out of {$results['total']}. Failed: {$results['failed']}";
            } else {
                // Scrape all streamers from the main page
                $results = $scraper->scrapeAll();
                $message = "Successfully scraped {$results['success']} streamers out of {$results['total']}. Failed: {$results['failed']}";
            }
            
            return back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('StreamerBans scrape failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed to scrape StreamerBans: ' . $e->getMessage());
        }
    }

    /**
     * Scrape a specific streamer.
     */
    public function scrapeStreamer(Request $request, StreamerBansScraperService $scraper)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
        ]);

        try {
            $success = $scraper->scrapeStreamer($validated['username']);
            
            if ($success) {
                return back()->with('success', "Successfully scraped data for {$validated['username']}");
            } else {
                return back()->with('error', "Failed to scrape data for {$validated['username']}");
            }
        } catch (\Exception $e) {
            \Log::error('StreamerBans scrape failed for ' . $validated['username'] . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to scrape streamer: ' . $e->getMessage());
        }
    }

    /**
     * Toggle streamer published status.
     */
    public function togglePublish(StreamerBan $streamerBan)
    {
        $streamerBan->update([
            'is_published' => !$streamerBan->is_published,
        ]);

        $status = $streamerBan->is_published ? 'published' : 'unpublished';
        return back()->with('success', "Streamer has been {$status}.");
    }

    /**
     * Toggle streamer featured status.
     */
    public function toggleFeature(StreamerBan $streamerBan)
    {
        $streamerBan->update([
            'is_featured' => !$streamerBan->is_featured,
        ]);

        $status = $streamerBan->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Streamer has been {$status}.");
    }

    /**
     * Delete a streamer.
     */
    public function deleteStreamer(StreamerBan $streamerBan)
    {
        $streamerBan->delete();

        return back()->with('success', 'Streamer deleted successfully!');
    }
}
