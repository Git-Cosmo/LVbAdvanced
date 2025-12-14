@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">🎮 Multiplayer Lobby</h1>
        <p class="dark:text-dark-text-secondary text-lg">Join a room or create your own to play with friends!</p>
    </div>

    <!-- Available Rooms -->
    @if($rooms->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rooms as $room)
                <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6 hover:border-accent-purple transition-colors">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-semibold dark:text-dark-text-bright">Room: {{ $room->code }}</h3>
                            <p class="text-sm dark:text-dark-text-tertiary">{{ ucfirst($room->game_type) }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs bg-green-500/20 text-green-400 rounded">{{ $room->status }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white text-sm font-bold">
                            {{ substr($room->host->name, 0, 1) }}
                        </div>
                        <span class="text-sm dark:text-dark-text-secondary">Host: {{ $room->host->name }}</span>
                    </div>

                    <div class="text-sm dark:text-dark-text-tertiary mb-4">
                        Players: {{ $room->players->count() }} / {{ $room->max_players }}
                    </div>

                    <form action="{{ route('multiplayer.join', $room->code) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity">
                            Join Room
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary">
            <span class="text-6xl mb-4 block">🎮</span>
            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">No Active Rooms</h3>
            <p class="dark:text-dark-text-secondary">Create a room to start playing!</p>
        </div>
    @endif

    <!-- Info Box -->
    <div class="mt-8 dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
        <h3 class="font-semibold dark:text-dark-text-bright mb-3">Multiplayer Features Coming Soon!</h3>
        <p class="dark:text-dark-text-secondary text-sm">
            Play trivia, millionaire, and geoguessr games with friends in real-time. Create a room, invite friends, and compete for the highest score!
        </p>
    </div>
</div>
@endsection
