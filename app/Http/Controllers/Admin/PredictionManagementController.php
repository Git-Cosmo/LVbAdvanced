<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResolvePredictionRequest;
use App\Http\Requests\Admin\StorePredictionRequest;
use App\Models\Prediction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PredictionManagementController extends Controller
{
    public function index(): View
    {
        $predictions = Prediction::withCount('entries')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.casual-games.predictions.index', [
            'predictions' => $predictions,
            'page' => (object) ['title' => 'Predictions Management'],
        ]);
    }

    public function create(): View
    {
        return view('admin.casual-games.predictions.create', [
            'page' => (object) ['title' => 'Create Prediction'],
        ]);
    }

    public function store(StorePredictionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Prediction::create($validated);

        return redirect()->route('admin.casual-games.predictions.index')
            ->with('success', 'Prediction created successfully!');
    }

    public function resolve(ResolvePredictionRequest $request, Prediction $prediction): RedirectResponse
    {
        $validated = $request->validated();

        $prediction->update([
            'correct_option_index' => $validated['correct_option_index'],
            'status' => 'resolved',
            'resolves_at' => now(),
        ]);

        // Award points to correct predictions
        $correctEntries = $prediction->entries()
            ->where('selected_option_index', $validated['correct_option_index'])
            ->get();

        foreach ($correctEntries as $entry) {
            $entry->update([
                'is_correct' => true,
                'points_won' => $prediction->points_reward,
            ]);

            // Update user profile points
            $user = $entry->user;
            if ($user && $user->profile) {
                $user->profile->increment('points', $prediction->points_reward);
            }
        }

        return back()->with('success', 'Prediction resolved and points awarded!');
    }
}
