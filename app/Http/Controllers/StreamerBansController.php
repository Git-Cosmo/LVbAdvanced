<?php

namespace App\Http\Controllers;

use App\Models\StreamerBan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StreamerBansController extends Controller
{
    /**
     * Display a listing of streamers with bans.
     */
    public function index(Request $request): View
    {
        $query = StreamerBan::published();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('username', 'like', '%' . $search . '%');
        }

        // Sorting
        $sort = $request->input('sort', 'most_bans');
        switch ($sort) {
            case 'most_bans':
                $query->orderBy('total_bans', 'desc');
                break;
            case 'recent':
                $query->orderBy('last_scraped_at', 'desc');
                break;
            case 'alphabetical':
                $query->orderBy('username', 'asc');
                break;
        }

        $streamers = $query->paginate(30);

        $stats = [
            'total_streamers' => StreamerBan::published()->count(),
            'total_bans' => StreamerBan::published()->sum('total_bans'),
        ];

        return view('streamerbans.index', compact('streamers', 'stats', 'sort'));
    }

    /**
     * Display a specific streamer's ban details.
     */
    public function show(StreamerBan $streamerBan): View
    {
        // Only show published streamers to public
        if (!$streamerBan->is_published) {
            abort(404);
        }

        // Increment view count
        $streamerBan->increment('views_count');

        // Get related streamers (similar ban counts)
        $relatedStreamers = StreamerBan::published()
            ->where('id', '!=', $streamerBan->id)
            ->whereBetween('total_bans', [
                max(0, $streamerBan->total_bans - 5),
                $streamerBan->total_bans + 5
            ])
            ->take(6)
            ->get();

        return view('streamerbans.show', compact('streamerBan', 'relatedStreamers'));
    }
}
