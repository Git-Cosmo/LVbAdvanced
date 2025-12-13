<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDailyChallengeRequest;
use App\Models\DailyChallenge;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DailyChallengeManagementController extends Controller
{
    public function index(): View
    {
        $challenges = DailyChallenge::withCount('completions')
            ->orderByDesc('valid_date')
            ->paginate(20);

        return view('admin.casual-games.challenges.index', [
            'challenges' => $challenges,
            'page' => (object) ['title' => 'Daily Challenges'],
        ]);
    }

    public function create(): View
    {
        return view('admin.casual-games.challenges.create', [
            'page' => (object) ['title' => 'Create Challenge'],
        ]);
    }

    public function store(StoreDailyChallengeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DailyChallenge::create($validated);

        return redirect()->route('admin.casual-games.challenges.index')
            ->with('success', 'Daily challenge created successfully!');
    }

    public function destroy(DailyChallenge $challenge): RedirectResponse
    {
        $challenge->delete();

        return redirect()->route('admin.casual-games.challenges.index')
            ->with('success', 'Challenge deleted successfully!');
    }
}
