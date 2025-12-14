@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Game Details -->
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 mb-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright mb-2">{{ $game->title }}</h1>
                <p class="dark:text-dark-text-secondary">{{ $game->description }}</p>
            </div>
            <span class="px-3 py-1 text-sm rounded {{ $game->difficulty_color }}">{{ ucfirst($game->difficulty) }}</span>
        </div>

        <!-- Game Stats -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="text-center p-4 bg-dark-bg-tertiary rounded-lg">
                <div class="text-2xl font-bold text-yellow-500">15</div>
                <div class="text-sm dark:text-dark-text-tertiary">Questions</div>
            </div>
            <div class="text-center p-4 bg-dark-bg-tertiary rounded-lg">
                <div class="text-2xl font-bold text-green-500">3</div>
                <div class="text-sm dark:text-dark-text-tertiary">Lifelines</div>
            </div>
            <div class="text-center p-4 bg-dark-bg-tertiary rounded-lg">
                <div class="text-2xl font-bold text-purple-500">$1M</div>
                <div class="text-sm dark:text-dark-text-tertiary">Top Prize</div>
            </div>
        </div>

        <!-- How to Play -->
        <div class="dark:bg-dark-bg-tertiary rounded-lg p-6 mb-6">
            <h3 class="font-semibold dark:text-dark-text-bright mb-3">How to Play</h3>
            <ul class="space-y-2 dark:text-dark-text-secondary text-sm">
                <li>✅ Answer 15 questions correctly to win the top prize</li>
                <li>💡 Use 3 lifelines: 50:50, Phone a Friend, Ask the Audience</li>
                <li>🎯 Safe havens at questions 5 and 10</li>
                <li>🚶 Walk away anytime to keep your winnings</li>
                <li>❌ Wrong answer loses money unless you reached a safe haven</li>
            </ul>
        </div>

        <!-- Start Button -->
        @auth
            @if($userAttempt)
                <a href="{{ route('casual-games.millionaire.play', [$game, $userAttempt]) }}" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                    Continue Game (Question {{ $userAttempt->current_question }})
                </a>
            @else
                <form action="{{ route('casual-games.millionaire.start', $game) }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                        Start New Game
                    </button>
                </form>
            @endif
        @else
            <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                Login to Play
            </a>
        @endauth
    </div>

    <!-- Back Link -->
    <div class="text-center">
        <a href="{{ route('casual-games.millionaire.index') }}" class="text-accent-blue hover:text-accent-blue-bright">
            ← Back to Millionaire Games
        </a>
    </div>
</div>
@endsection
