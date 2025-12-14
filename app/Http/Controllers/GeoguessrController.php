<?php

namespace App\Http\Controllers;

use App\Models\GeoguessrAttempt;
use App\Models\GeoguessrGame;
use Illuminate\Http\Request;

class GeoguessrController extends Controller
{
    public function index()
    {
        $games = GeoguessrGame::active()
            ->withCount('locations')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('casual-games.geoguessr.index', [
            'games' => $games,
            'page' => (object) ['title' => 'GeoGuessr Games'],
        ]);
    }

    public function show(GeoguessrGame $geoguessrGame)
    {
        $geoguessrGame->loadCount('locations');

        $userAttempt = null;
        if (auth()->check()) {
            $userAttempt = GeoguessrAttempt::where('user_id', auth()->id())
                ->where('geoguessr_game_id', $geoguessrGame->id)
                ->where('status', 'in_progress')
                ->first();
        }

        return view('casual-games.geoguessr.show', [
            'game' => $geoguessrGame,
            'userAttempt' => $userAttempt,
            'page' => (object) ['title' => $geoguessrGame->title],
        ]);
    }

    public function start(GeoguessrGame $geoguessrGame)
    {
        // Check if user has an active attempt
        $existingAttempt = GeoguessrAttempt::where('user_id', auth()->id())
            ->where('geoguessr_game_id', $geoguessrGame->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('casual-games.geoguessr.play', [$geoguessrGame, $existingAttempt]);
        }

        // Create new attempt
        $attempt = GeoguessrAttempt::create([
            'user_id' => auth()->id(),
            'geoguessr_game_id' => $geoguessrGame->id,
            'total_score' => 0,
            'rounds_completed' => 0,
            'status' => 'in_progress',
            'started_at' => now(),
            'round_data' => [],
        ]);

        return redirect()->route('casual-games.geoguessr.play', [$geoguessrGame, $attempt]);
    }

    public function play(GeoguessrGame $geoguessrGame, GeoguessrAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        if ($attempt->status !== 'in_progress') {
            return redirect()->route('casual-games.geoguessr.result', [$geoguessrGame, $attempt]);
        }

        // Check if game is complete
        if ($attempt->rounds_completed >= $geoguessrGame->rounds) {
            $attempt->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Award points
            if (auth()->user()->profile) {
                $points = round($attempt->total_score / 10); // Convert score to points
                auth()->user()->profile->increment('points', $points);
            }

            return redirect()->route('casual-games.geoguessr.result', [$geoguessrGame, $attempt]);
        }

        // Get random location for current round
        $location = $geoguessrGame->locations()->inRandomOrder()->first();

        if (!$location) {
            return back()->with('error', 'No locations available for this game.');
        }

        return view('casual-games.geoguessr.play', [
            'game' => $geoguessrGame,
            'attempt' => $attempt,
            'location' => $location,
            'currentRound' => $attempt->rounds_completed + 1,
            'page' => (object) ['title' => 'Playing: '.$geoguessrGame->title],
        ]);
    }

    public function submitGuess(Request $request, GeoguessrGame $geoguessrGame, GeoguessrAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        if ($attempt->status !== 'in_progress') {
            return response()->json(['error' => 'Game is not in progress'], 400);
        }

        $validated = $request->validate([
            'location_id' => 'required|exists:geoguessr_locations,id',
            'guess_lat' => 'required|numeric|between:-90,90',
            'guess_lng' => 'required|numeric|between:-180,180',
            'time_taken' => 'nullable|integer|min:0',
        ]);

        $location = $geoguessrGame->locations()->findOrFail($validated['location_id']);

        // Calculate distance and score
        $distance = $location->calculateDistance($validated['guess_lat'], $validated['guess_lng']);
        $score = $location->calculateScore(
            $validated['guess_lat'],
            $validated['guess_lng'],
            $geoguessrGame->max_points_per_round
        );

        // Update attempt
        $roundData = $attempt->round_data ?? [];
        $roundData[] = [
            'round' => $attempt->rounds_completed + 1,
            'location_id' => $location->id,
            'guess_lat' => $validated['guess_lat'],
            'guess_lng' => $validated['guess_lng'],
            'actual_lat' => $location->latitude,
            'actual_lng' => $location->longitude,
            'distance' => round($distance, 2),
            'score' => $score,
            'time_taken' => $validated['time_taken'] ?? null,
        ];

        $attempt->update([
            'rounds_completed' => $attempt->rounds_completed + 1,
            'total_score' => $attempt->total_score + $score,
            'round_data' => $roundData,
        ]);

        return response()->json([
            'success' => true,
            'distance' => round($distance, 2),
            'score' => $score,
            'total_score' => $attempt->total_score,
            'rounds_completed' => $attempt->rounds_completed,
            'location' => [
                'name' => $location->name,
                'country' => $location->country,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
            ],
        ]);
    }

    public function result(GeoguessrGame $geoguessrGame, GeoguessrAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        $attempt->load('geoguessrGame');

        return view('casual-games.geoguessr.result', [
            'game' => $geoguessrGame,
            'attempt' => $attempt,
            'page' => (object) ['title' => 'Game Results'],
        ]);
    }
}
