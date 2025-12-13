<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ServerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGameServerRequest;
use App\Http\Requests\Admin\UpdateGameServerRequest;
use App\Models\GameServer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GameServerController extends Controller
{
    /**
     * Display a listing of game servers.
     */
    public function index(): View
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
    public function create(): View
    {
        return view('admin.game-servers.create');
    }

    /**
     * Store a newly created game server.
     */
    public function store(StoreGameServerRequest $request): RedirectResponse
    {
        $validated = $request->validated();
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
    public function edit(GameServer $gameServer): View
    {
        return view('admin.game-servers.edit', compact('gameServer'));
    }

    /**
     * Update the specified game server.
     */
    public function update(UpdateGameServerRequest $request, GameServer $gameServer): RedirectResponse
    {
        $validated = $request->validated();
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
    public function destroy(GameServer $gameServer): RedirectResponse
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
    public function toggleActive(GameServer $gameServer): RedirectResponse
    {
        $gameServer->update(['is_active' => ! $gameServer->is_active]);

        return back()->with('success', 'Server status toggled successfully!');
    }

    /**
     * Toggle the featured status of a game server.
     */
    public function toggleFeatured(GameServer $gameServer): RedirectResponse
    {
        $gameServer->update(['is_featured' => ! $gameServer->is_featured]);

        return back()->with('success', 'Featured status toggled successfully!');
    }
}
