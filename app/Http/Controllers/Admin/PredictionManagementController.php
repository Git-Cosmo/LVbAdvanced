<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prediction;
use Illuminate\Http\Request;

class PredictionManagementController extends Controller
{
    public function index()
    {
        $predictions = Prediction::withCount('entries')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.casual-games.predictions.index', [
            'predictions' => $predictions,
            'page' => (object) ['title' => 'Predictions Management'],
        ]);
    }

    public function create()
    {
        return view('admin.casual-games.predictions.create', [
            'page' => (object) ['title' => 'Create Prediction'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'points_reward' => 'required|integer|min:1',
            'closes_at' => 'required|date|after:now',
        ]);

        Prediction::create($validated);

        return redirect()->route('admin.casual-games.predictions.index')
            ->with('success', 'Prediction created successfully!');
    }

    public function resolve(Request $request, Prediction $prediction)
    {
        $validated = $request->validate([
            'correct_option_index' => 'required|integer|min:0',
        ]);

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
