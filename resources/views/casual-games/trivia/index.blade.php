@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">🧠 Trivia Games</h1>
        <p class="dark:text-dark-text-secondary text-lg">Test your knowledge and earn points!</p>
    </div>

    <!-- Games Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($games as $game)
            <div class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-blue-500 transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright">{{ $game->title }}</h3>
                    <span class="px-3 py-1 rounded text-sm font-semibold
                        @if($game->difficulty == 'easy') bg-green-500/20 text-green-400
                        @elseif($game->difficulty == 'medium') bg-yellow-500/20 text-yellow-400
                        @else bg-red-500/20 text-red-400
                        @endif">
                        {{ ucfirst($game->difficulty) }}
                    </span>
                </div>

                <p class="dark:text-dark-text-secondary mb-4">{{ $game->description }}</p>

                <div class="flex justify-between items-center text-sm dark:text-dark-text-tertiary mb-4">
                    <span>🧠 {{ $game->questions_count }} Questions</span>
                    <span>⏱️ {{ $game->time_limit }}s</span>
                    <span>💰 {{ $game->points_reward }} pts</span>
                </div>

                <a href="{{ route('casual-games.trivia.show', $game) }}" 
                   class="block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-center py-2 rounded-lg font-semibold transition-all">
                    Play Now
                </a>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="dark:text-dark-text-secondary text-lg">No trivia games available at the moment.</p>
                <p class="dark:text-dark-text-tertiary text-sm mt-2">Check back soon for new trivia challenges!</p>
            </div>
        @endforelse
    </div>

    @if($games->hasPages())
        <div class="mt-8">
            {{ $games->links() }}
        </div>
    @endif
</div>
@endsection
