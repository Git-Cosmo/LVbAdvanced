<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\GameIntegration;
use App\Models\GameLibrary;
use App\Models\RecentlyPlayed;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GamerIntegrationController extends Controller
{
    /**
     * Display the gamer integrations dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        
        $integrations = GameIntegration::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        $stats = [
            'total_games' => GameLibrary::where('user_id', $user->id)->count(),
            'total_playtime' => GameLibrary::where('user_id', $user->id)->sum('playtime_minutes'),
            'platforms' => GameIntegration::where('user_id', $user->id)->where('is_active', true)->count(),
            'clans' => $user->clanMembers()->count(),
        ];

        return view('integrations.index', compact('integrations', 'stats'));
    }

    /**
     * Display the user's game library.
     */
    public function library(): View
    {
        $user = auth()->user();
        
        $games = GameLibrary::where('user_id', $user->id)
            ->with('integration')
            ->orderBy('playtime_minutes', 'desc')
            ->paginate(24);

        return view('integrations.library', compact('games'));
    }

    /**
     * Display recently played games.
     */
    public function recentlyPlayed(): View
    {
        $user = auth()->user();
        
        $recentGames = RecentlyPlayed::where('user_id', $user->id)
            ->with('gameLibrary')
            ->orderBy('last_played_at', 'desc')
            ->take(20)
            ->get();

        return view('integrations.recently-played', compact('recentGames'));
    }

    /**
     * Display clans list.
     */
    public function clans(): View
    {
        $clans = Clan::public()
            ->with('owner')
            ->withCount('members')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('integrations.clans.index', compact('clans'));
    }

    /**
     * Display a specific clan.
     */
    public function showClan(Clan $clan): View
    {
        $clan->load(['owner', 'members.user', 'forums', 'events']);
        
        return view('integrations.clans.show', compact('clan'));
    }
}
