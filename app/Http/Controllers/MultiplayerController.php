<?php

namespace App\Http\Controllers;

use App\Events\GameRoomUpdated;
use App\Events\GameStarted;
use App\Events\PlayerJoinedRoom;
use App\Models\GameRoom;
use App\Models\GameRoomPlayer;
use Illuminate\Http\Request;

class MultiplayerController extends Controller
{
    public function lobby()
    {
        $rooms = GameRoom::with(['host', 'players'])
            ->where('status', 'waiting')
            ->latest()
            ->paginate(12);

        return view('multiplayer.lobby', [
            'rooms' => $rooms,
            'page' => (object) ['title' => 'Multiplayer Lobby'],
        ]);
    }

    public function createRoom(Request $request)
    {
        $validated = $request->validate([
            'game_type' => 'required|in:millionaire,geoguessr,trivia',
            'game_id' => 'required|integer',
            'max_players' => 'required|integer|min:2|max:20',
        ]);

        $room = GameRoom::create([
            'game_type' => $validated['game_type'],
            'game_id' => $validated['game_id'],
            'host_user_id' => auth()->id(),
            'max_players' => $validated['max_players'],
            'status' => 'waiting',
        ]);

        // Add host as first player
        GameRoomPlayer::create([
            'game_room_id' => $room->id,
            'user_id' => auth()->id(),
            'status' => 'ready',
            'joined_at' => now(),
        ]);

        broadcast(new GameRoomUpdated($room, 'created'))->toOthers();

        return redirect()->route('multiplayer.room', $room->code);
    }

    public function room($code)
    {
        $room = GameRoom::with(['host', 'players.user'])
            ->where('code', $code)
            ->firstOrFail();

        return view('multiplayer.room', [
            'room' => $room,
            'page' => (object) ['title' => 'Game Room: '.$room->code],
        ]);
    }

    public function joinRoom(Request $request, $code)
    {
        $room = GameRoom::where('code', $code)->firstOrFail();

        if (!$room->canJoin(auth()->user())) {
            return back()->with('error', 'Cannot join this room.');
        }

        GameRoomPlayer::create([
            'game_room_id' => $room->id,
            'user_id' => auth()->id(),
            'status' => 'waiting',
            'joined_at' => now(),
        ]);

        broadcast(new PlayerJoinedRoom($room, auth()->user()))->toOthers();

        return redirect()->route('multiplayer.room', $code);
    }

    public function leaveRoom($code)
    {
        $room = GameRoom::where('code', $code)->firstOrFail();

        $player = GameRoomPlayer::where('game_room_id', $room->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($player) {
            $player->update(['status' => 'left']);

            // If host leaves, cancel the room
            if ($room->host_user_id === auth()->id()) {
                $room->update(['status' => 'cancelled']);
            }
        }

        return redirect()->route('multiplayer.lobby');
    }

    public function startGame($code)
    {
        $room = GameRoom::where('code', $code)->firstOrFail();

        // Only host can start
        if ($room->host_user_id !== auth()->id()) {
            return back()->with('error', 'Only the host can start the game.');
        }

        $room->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        // Update all players to playing status
        $room->players()->update(['status' => 'playing']);

        broadcast(new GameStarted($room))->toOthers();

        return redirect()->route('multiplayer.play', $code);
    }

    public function play($code)
    {
        $room = GameRoom::with(['host', 'players.user'])
            ->where('code', $code)
            ->firstOrFail();

        if ($room->status !== 'in_progress') {
            return redirect()->route('multiplayer.room', $code);
        }

        return view('multiplayer.play', [
            'room' => $room,
            'page' => (object) ['title' => 'Playing: '.$room->code],
        ]);
    }
}
