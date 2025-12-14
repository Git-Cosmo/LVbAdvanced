@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">🎮 Casual Games</h1>
        <p class="dark:text-dark-text-secondary text-lg">Play, predict, challenge yourself, and earn points!</p>
    </div>

    <!-- Featured Games -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <a href="{{ route('casual-games.millionaire.index') }}" class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-yellow-500 transition-colors group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center text-3xl">
                    💰
                </div>
                <span class="px-3 py-1 text-xs font-semibold bg-yellow-500/20 text-yellow-400 rounded">NEW!</span>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">Millionaire</h3>
            <p class="text-sm dark:text-dark-text-secondary">Answer 15 questions and win big with lifelines!</p>
        </a>

        <a href="{{ route('casual-games.geoguessr.index') }}" class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-green-500 transition-colors group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-500 rounded-lg flex items-center justify-center text-3xl">
                    🗺️
                </div>
                <span class="px-3 py-1 text-xs font-semibold bg-green-500/20 text-green-400 rounded">NEW!</span>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">GeoGuessr</h3>
            <p class="text-sm dark:text-dark-text-secondary">Test your geography skills and guess locations!</p>
        </a>

        <a href="{{ route('casual-games.trivia.index') }}" class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-blue-500 transition-colors group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-blue-500/20 rounded-lg flex items-center justify-center text-3xl">
                    🧠
                </div>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">Trivia Games</h3>
            <p class="text-sm dark:text-dark-text-secondary">Test your knowledge with fun trivia quizzes!</p>
        </a>

        <a href="{{ route('casual-games.predictions.index') }}" class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-purple-500 transition-colors group">
            <div class="w-16 h-16 bg-purple-500/20 rounded-lg flex items-center justify-center text-3xl mb-4">
                🔮
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">Predictions</h3>
            <p class="text-sm dark:text-dark-text-secondary">Make predictions and earn rewards!</p>
        </a>

        <a href="{{ route('casual-games.challenges.index') }}" class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-green-500 transition-colors group">
            <div class="w-16 h-16 bg-green-500/20 rounded-lg flex items-center justify-center text-3xl mb-4">
                🎯
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">Daily Challenges</h3>
            <p class="text-sm dark:text-dark-text-secondary">Complete challenges for bonus points!</p>
        </a>

        <a href="{{ route('multiplayer.lobby') }}" class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-pink-500 transition-colors group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-500 rounded-lg flex items-center justify-center text-3xl">
                    🎮
                </div>
                <span class="px-3 py-1 text-xs font-semibold bg-pink-500/20 text-pink-400 rounded">NEW!</span>
            </div>
            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">Multiplayer</h3>
            <p class="text-sm dark:text-dark-text-secondary">Play with friends in real-time!</p>
        </a>
    </div>

    <!-- Trivia Games Section -->
    @if($triviaGames->count() > 0)
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold dark:text-dark-text-bright">🧠 Trivia Games</h2>
                <a href="{{ route('casual-games.trivia.index') }}" class="text-accent-blue hover:text-accent-blue-bright">View All →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($triviaGames as $game)
                    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary overflow-hidden hover:border-accent-blue transition-colors">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="font-semibold dark:text-dark-text-bright">{{ $game->title }}</h3>
                                <span class="px-2 py-1 text-xs rounded {{ $game->difficulty_color }}">{{ ucfirst($game->difficulty) }}</span>
                            </div>
                            <p class="dark:text-dark-text-secondary text-sm mb-4">{{ Str::limit($game->description, 80) }}</p>
                            <div class="flex items-center justify-between text-sm dark:text-dark-text-tertiary mb-4">
                                <span>{{ $game->questions_count }} questions</span>
                                <span>{{ $game->time_limit }}s each</span>
                            </div>
                            <a href="{{ route('casual-games.trivia.show', $game) }}" class="block w-full text-center px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity">
                                Play Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Predictions Section -->
    @if($predictions->count() > 0)
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold dark:text-dark-text-bright">🔮 Make Your Predictions</h2>
                <a href="{{ route('casual-games.predictions.index') }}" class="text-accent-blue hover:text-accent-blue-bright">View All →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($predictions as $prediction)
                    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6 hover:border-accent-purple transition-colors">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="font-semibold dark:text-dark-text-bright">{{ $prediction->title }}</h3>
                            <span class="px-2 py-1 text-xs bg-purple-500/20 text-purple-400 rounded">{{ ucfirst($prediction->category) }}</span>
                        </div>
                        <p class="dark:text-dark-text-secondary text-sm mb-4">{{ Str::limit($prediction->description, 120) }}</p>
                        <div class="flex items-center justify-between text-sm mb-4">
                            <span class="dark:text-dark-text-tertiary">{{ $prediction->total_entries }} predictions</span>
                            <span class="dark:text-dark-text-tertiary">Closes {{ $prediction->closes_at->diffForHumans() }}</span>
                        </div>
                        <a href="{{ route('casual-games.predictions.show', $prediction) }}" class="block w-full text-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:opacity-90 transition-opacity">
                            Make Prediction
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Daily Challenges -->
    @if($dailyChallenges->count() > 0)
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold dark:text-dark-text-bright">🎯 Today's Challenges</h2>
                <a href="{{ route('casual-games.challenges.index') }}" class="text-accent-blue hover:text-accent-blue-bright">View All →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($dailyChallenges as $challenge)
                    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
                        <h3 class="font-semibold dark:text-dark-text-bright mb-2">{{ $challenge->title }}</h3>
                        <p class="dark:text-dark-text-secondary text-sm mb-4">{{ $challenge->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-green-500">+{{ $challenge->points_reward }} points</span>
                            <span class="px-2 py-1 text-xs bg-green-500/20 text-green-400 rounded">{{ ucfirst($challenge->challenge_type) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($triviaGames->count() == 0 && $predictions->count() == 0 && $dailyChallenges->count() == 0)
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gradient-to-br from-accent-blue to-accent-purple rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-4xl">🎮</span>
            </div>
            <h3 class="text-2xl font-bold dark:text-dark-text-bright mb-2">No Games Available</h3>
            <p class="dark:text-dark-text-secondary">Check back soon for new challenges and games!</p>
        </div>
    @endif
</div>
@endsection
