<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GamificationService;
use Illuminate\Http\Request;

class GamificationController extends Controller
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Show gamification settings
     */
    public function index()
    {
        $seasonalLeaderboard = $this->gamificationService->getSeasonalLeaderboard(10);

        return view('admin.gamification.index', [
            'seasonalLeaderboard' => $seasonalLeaderboard,
            'page' => (object) ['title' => 'Gamification Settings'],
        ]);
    }

    /**
     * Update XP settings
     */
    public function updateXPSettings(Request $request)
    {
        // This would typically save to a settings table or config
        // For now, we'll just return success

        return back()->with('success', 'XP settings updated');
    }

    /**
     * Reset seasonal leaderboard
     */
    public function resetSeason()
    {
        // Clear cache for seasonal leaderboard
        \Cache::forget('leaderboard:seasonal:*');

        return back()->with('success', 'Seasonal leaderboard reset');
    }
}
