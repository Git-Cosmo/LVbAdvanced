<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeoguessrGame;
use App\Models\GeoguessrLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeoguessrManagementController extends Controller
{
    public function index()
    {
        $games = GeoguessrGame::withCount('locations', 'attempts')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.casual-games.geoguessr.index', [
            'games' => $games,
            'page' => (object) ['title' => 'GeoGuessr Games'],
        ]);
    }

    public function create()
    {
        return view('admin.casual-games.geoguessr.create', [
            'page' => (object) ['title' => 'Create GeoGuessr Game'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rounds' => 'required|integer|min:1|max:10',
            'time_per_round' => 'required|integer|min:30|max:300',
            'max_points_per_round' => 'required|integer|min:100|max:10000',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        GeoguessrGame::create($validated);

        return redirect()->route('admin.casual-games.geoguessr.index')
            ->with('success', 'GeoGuessr game created successfully!');
    }

    public function edit(GeoguessrGame $geoguessrGame)
    {
        $geoguessrGame->load('locations');

        return view('admin.casual-games.geoguessr.edit', [
            'game' => $geoguessrGame,
            'page' => (object) ['title' => 'Edit: ' . $geoguessrGame->title],
        ]);
    }

    public function update(Request $request, GeoguessrGame $geoguessrGame)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rounds' => 'required|integer|min:1|max:10',
            'time_per_round' => 'required|integer|min:30|max:300',
            'max_points_per_round' => 'required|integer|min:100|max:10000',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        $geoguessrGame->update($validated);

        return redirect()->route('admin.casual-games.geoguessr.index')
            ->with('success', 'GeoGuessr game updated successfully!');
    }

    public function destroy(GeoguessrGame $geoguessrGame)
    {
        $geoguessrGame->delete();

        return redirect()->route('admin.casual-games.geoguessr.index')
            ->with('success', 'GeoGuessr game deleted successfully!');
    }

    public function addLocation(Request $request, GeoguessrGame $geoguessrGame)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image_url' => 'required|url',
            'hint' => 'nullable|string',
            'difficulty_rating' => 'required|integer|min:1|max:5',
        ]);

        $validated['geoguessr_game_id'] = $geoguessrGame->id;

        GeoguessrLocation::create($validated);

        return redirect()->route('admin.casual-games.geoguessr.edit', $geoguessrGame)
            ->with('success', 'Location added successfully!');
    }

    public function deleteLocation(GeoguessrGame $geoguessrGame, GeoguessrLocation $location)
    {
        $location->delete();

        return redirect()->route('admin.casual-games.geoguessr.edit', $geoguessrGame)
            ->with('success', 'Location deleted successfully!');
    }
}
