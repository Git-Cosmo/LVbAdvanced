<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyChallenge;
use Illuminate\Http\Request;

class DailyChallengeManagementController extends Controller
{
    public function index()
    {
        $challenges = DailyChallenge::withCount('completions')
            ->orderByDesc('valid_date')
            ->paginate(20);

        return view('admin.casual-games.challenges.index', [
            'challenges' => $challenges,
            'page' => (object) ['title' => 'Daily Challenges'],
        ]);
    }

    public function create()
    {
        return view('admin.casual-games.challenges.create', [
            'page' => (object) ['title' => 'Create Challenge'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'challenge_type' => 'required|string',
            'requirements' => 'required|array',
            'points_reward' => 'required|integer|min:1',
            'valid_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        DailyChallenge::create($validated);

        return redirect()->route('admin.casual-games.challenges.index')
            ->with('success', 'Daily challenge created successfully!');
    }

    public function destroy(DailyChallenge $challenge)
    {
        $challenge->delete();

        return redirect()->route('admin.casual-games.challenges.index')
            ->with('success', 'Challenge deleted successfully!');
    }
}
