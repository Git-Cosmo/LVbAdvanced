@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright mb-2">{{ $game->title }}</h1>
                <span class="px-3 py-1 text-sm rounded {{ $game->difficulty_color }}">{{ ucfirst($game->difficulty) }}</span>
            </div>
            <div class="text-6xl">📝</div>
        </div>

        <p class="dark:text-dark-text-secondary mb-6">{{ $game->description }}</p>

        <!-- Game Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-purple-500">{{ $game->words_count }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Words</div>
            </div>
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-500">{{ $game->time_per_word }}s</div>
                <div class="text-sm dark:text-dark-text-tertiary">Per Word</div>
            </div>
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-500">{{ $game->points_per_word }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Points</div>
            </div>
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-red-500">-{{ $game->hint_penalty }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Hint Penalty</div>
            </div>
        </div>

        <!-- How to Play -->
        <div class="dark:bg-dark-bg-tertiary rounded-lg p-6 mb-6">
            <h3 class="font-semibold dark:text-dark-text-bright mb-3">How to Play:</h3>
            <ul class="space-y-2 dark:text-dark-text-secondary">
                <li>• Unscramble the letters to form the correct word</li>
                <li>• Words are all related to gaming, esports, and streaming</li>
                <li>• Use hints if you're stuck (costs {{ $game->hint_penalty }} points)</li>
                <li>• Faster solves earn time bonuses (up to 50% extra points)</li>
                <li>• Skip words you can't solve (no points earned)</li>
            </ul>
        </div>

        <!-- Action Buttons -->
        @auth
            @if($userAttempt)
                <div class="mb-4">
                    <div class="bg-yellow-500/20 border border-yellow-500 rounded-lg p-4 text-yellow-400 mb-4">
                        You have a game in progress!
                    </div>
                    <a href="{{ route('casual-games.word-scramble.play', [$game, $userAttempt]) }}" class="block w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold text-center">
                        Continue Game
                    </a>
                </div>
            @else
                <form action="{{ route('casual-games.word-scramble.start', $game) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                        Start New Game
                    </button>
                </form>
            @endif
        @else
            <div class="text-center py-4">
                <p class="dark:text-dark-text-secondary mb-4">Sign in to play this game!</p>
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-accent-blue text-white rounded-lg hover:bg-accent-blue-bright transition-colors">
                    Sign In
                </a>
            </div>
        @endauth

        <!-- Back Button -->
        <div class="mt-6 text-center">
            <a href="{{ route('casual-games.word-scramble.index') }}" class="text-accent-blue hover:text-accent-blue-bright">
                ← Back to Word Scramble Games
            </a>
        </div>
    </div>
</div>
@endsection
