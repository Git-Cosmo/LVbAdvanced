@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright mb-2">Room: {{ $room->code }}</h1>
                <p class="dark:text-dark-text-secondary">Game: {{ ucfirst($room->game_type) }}</p>
            </div>
            <span class="px-3 py-1 text-sm rounded bg-green-500/20 text-green-400">{{ ucfirst($room->status) }}</span>
        </div>

        <!-- Players List -->
        <div class="mb-6">
            <h3 class="font-semibold dark:text-dark-text-bright mb-4">Players ({{ $room->players->count() }}/{{ $room->max_players }})</h3>
            <div class="space-y-2">
                @foreach($room->players as $player)
                    <div class="flex items-center justify-between p-3 dark:bg-dark-bg-tertiary rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                {{ substr($player->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="dark:text-dark-text-bright">{{ $player->user->name }}</div>
                                @if($player->user_id === $room->host_user_id)
                                    <span class="text-xs text-yellow-500">👑 Host</span>
                                @endif
                            </div>
                        </div>
                        <span class="text-sm px-2 py-1 rounded {{ $player->status === 'ready' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                            {{ ucfirst($player->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            @if(auth()->id() === $room->host_user_id && $room->status === 'waiting')
                <form action="{{ route('multiplayer.start', $room->code) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                        Start Game
                    </button>
                </form>
            @endif
            
            <form action="{{ route('multiplayer.leave', $room->code) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                    Leave Room
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
