<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ReputationService;
use Illuminate\Http\Request;

class ReputationController extends Controller
{
    protected ReputationService $reputationService;

    public function __construct(ReputationService $reputationService)
    {
        $this->reputationService = $reputationService;
    }

    /**
     * Show reputation management dashboard
     */
    public function index()
    {
        $topUsers = $this->reputationService->getLeaderboard('xp', 'all-time', 20);

        return view('admin.reputation.index', [
            'topUsers' => $topUsers,
            'page' => (object) ['title' => 'Reputation Management'],
        ]);
    }

    /**
     * Award XP to a user
     */
    public function awardXP(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $this->reputationService->awardXP($user, $validated['amount'], $validated['reason']);

        return back()->with('success', "Awarded {$validated['amount']} XP to {$user->name}");
    }

    /**
     * Reset user level
     */
    public function resetLevel(User $user)
    {
        $user->profile->update([
            'xp' => 0,
            'level' => 1,
            'karma' => 0,
        ]);

        return back()->with('success', "Reset {$user->name}'s level and stats");
    }

    /**
     * Update karma for all users
     */
    public function recalculateKarma()
    {
        $users = User::all();
        foreach ($users as $user) {
            $this->reputationService->updateKarma($user);
        }

        return back()->with('success', 'Recalculated karma for all users');
    }
}
