<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameServer;
use Illuminate\Http\Request;

class GameServerController extends Controller
{
    /**
     * Display a listing of game servers.
     */
    public function index()
    {
        $servers = GameServer::orderBy('display_order')
            ->orderBy('name')
            ->paginate(20);

        $stats = [
            'total' => GameServer::count(),
            'active' => GameServer::where('is_active', true)->count(),
            'online' => GameServer::where('status', 'online')->count(),
            'featured' => GameServer::where('is_featured', true)->count(),
        ];

        return view('admin.game-servers.index', compact('servers', 'stats'));
    }

    /**
     * Show the form for creating a new game server.
     */
    public function create()
    {
        return view('admin.game-servers.create');
    }

    /**
     * Store a newly created game server.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'game' => 'required|string|max:255',
            'game_short_code' => 'required|string|max:10',
            'description' => 'nullable|string',
            'ip_address' => 'nullable|string|max:255',
            'port' => 'nullable|integer|min:1|max:65535',
            'connect_url' => 'nullable|string|max:500',
            'status' => 'required|in:online,offline,maintenance,coming_soon',
            'max_players' => 'nullable|integer|min:0',
            'current_players' => 'nullable|integer|min:0',
            'map' => 'nullable|string|max:255',
            'game_mode' => 'nullable|string|max:255',
            'icon_color_from' => 'required|string|max:7',
            'icon_color_to' => 'required|string|max:7',
            'display_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $server = GameServer::create($validated);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($server)
            ->log('created_game_server');

        return redirect()->route('admin.game-servers.index')
            ->with('success', 'Game server created successfully!');
    }

    /**
     * Show the form for editing the specified game server.
     */
    public function edit(GameServer $gameServer)
    {
        return view('admin.game-servers.edit', compact('gameServer'));
    }

    /**
     * Update the specified game server.
     */
    public function update(Request $request, GameServer $gameServer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'game' => 'required|string|max:255',
            'game_short_code' => 'required|string|max:10',
            'description' => 'nullable|string',
            'ip_address' => 'nullable|string|max:255',
            'port' => 'nullable|integer|min:1|max:65535',
            'connect_url' => 'nullable|string|max:500',
            'status' => 'required|in:online,offline,maintenance,coming_soon',
            'max_players' => 'nullable|integer|min:0',
            'current_players' => 'nullable|integer|min:0',
            'map' => 'nullable|string|max:255',
            'game_mode' => 'nullable|string|max:255',
            'icon_color_from' => 'required|string|max:7',
            'icon_color_to' => 'required|string|max:7',
            'display_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $gameServer->update($validated);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($gameServer)
            ->log('updated_game_server');

        return redirect()->route('admin.game-servers.index')
            ->with('success', 'Game server updated successfully!');
    }

    /**
     * Remove the specified game server.
     */
    public function destroy(GameServer $gameServer)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($gameServer)
            ->log('deleted_game_server');

        $gameServer->delete();

        return redirect()->route('admin.game-servers.index')
            ->with('success', 'Game server deleted successfully!');
    }

    /**
     * Toggle the active status of a game server.
     */
    public function toggleActive(GameServer $gameServer)
    {
        $gameServer->update(['is_active' => ! $gameServer->is_active]);

        return back()->with('success', 'Server status toggled successfully!');
    }

    /**
     * Toggle the featured status of a game server.
     */
    public function toggleFeatured(GameServer $gameServer)
    {
        $gameServer->update(['is_featured' => ! $gameServer->is_featured]);

        return back()->with('success', 'Featured status toggled successfully!');
    }
}
