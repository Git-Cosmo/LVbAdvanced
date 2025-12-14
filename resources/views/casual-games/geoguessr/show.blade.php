@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright mb-4">{{ $game->title }}</h1>
        <p class="dark:text-dark-text-secondary mb-6">{{ $game->description }}</p>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="text-center p-4 bg-dark-bg-tertiary rounded-lg">
                <div class="text-2xl font-bold text-green-500">{{ $game->rounds }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Rounds</div>
            </div>
            <div class="text-center p-4 bg-dark-bg-tertiary rounded-lg">
                <div class="text-2xl font-bold text-blue-500">{{ $game->time_per_round }}s</div>
                <div class="text-sm dark:text-dark-text-tertiary">Per Round</div>
            </div>
            <div class="text-center p-4 bg-dark-bg-tertiary rounded-lg">
                <div class="text-2xl font-bold text-purple-500">{{ number_format($game->max_points_per_round) }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Max Points</div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-tertiary rounded-lg p-6 mb-6">
            <h3 class="font-semibold dark:text-dark-text-bright mb-3">How to Play</h3>
            <ul class="space-y-2 dark:text-dark-text-secondary text-sm">
                <li>🗺️ View a location image and guess where it is on the map</li>
                <li>📍 Click on the map to place your guess</li>
                <li>🎯 The closer you are, the more points you earn</li>
                <li>⏱️ Complete all rounds before time runs out</li>
            </ul>
        </div>

        @auth
            @if($userAttempt)
                <a href="{{ route('casual-games.geoguessr.play', [$game, $userAttempt]) }}" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                    Continue Game (Round {{ $userAttempt->rounds_completed + 1 }})
                </a>
            @else
                <form action="{{ route('casual-games.geoguessr.start', $game) }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                        Start New Game
                    </button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                Login to Play
            </a>
        @endauth
    </div>

    <div class="text-center">
        <a href="{{ route('casual-games.geoguessr.index') }}" class="text-accent-blue hover:text-accent-blue-bright">
            ← Back to GeoGuessr Games
        </a>
    </div>
</div>
@endsection
