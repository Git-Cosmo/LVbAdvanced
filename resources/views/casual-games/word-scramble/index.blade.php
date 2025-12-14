@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">📝 Word Scramble</h1>
        <p class="dark:text-dark-text-secondary text-lg">Unscramble popular gaming words and test your knowledge!</p>
    </div>

    <!-- Games Grid -->
    @if($games->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($games as $game)
                <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary overflow-hidden hover:border-accent-purple transition-colors">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="font-semibold dark:text-dark-text-bright">{{ $game->title }}</h3>
                            <span class="px-2 py-1 text-xs rounded {{ $game->difficulty_color }}">{{ ucfirst($game->difficulty) }}</span>
                        </div>
                        <p class="dark:text-dark-text-secondary text-sm mb-4">{{ Str::limit($game->description, 100) }}</p>
                        <div class="flex items-center justify-between text-sm dark:text-dark-text-tertiary mb-4">
                            <span>{{ $game->words_count }} words</span>
                            <span>{{ $game->time_per_word }}s each</span>
                        </div>
                        <div class="flex items-center justify-between text-xs dark:text-dark-text-tertiary mb-4">
                            <span>{{ $game->points_per_word }} pts/word</span>
                            <span>-{{ $game->hint_penalty }} pts/hint</span>
                        </div>
                        <a href="{{ route('casual-games.word-scramble.show', $game) }}" class="block w-full text-center px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:opacity-90 transition-opacity">
                            Play Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($games->hasPages())
            <div class="mt-8">
                {{ $games->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-4xl">📝</span>
            </div>
            <h3 class="text-2xl font-bold dark:text-dark-text-bright mb-2">No Games Available</h3>
            <p class="dark:text-dark-text-secondary">Check back soon for new word scramble games!</p>
        </div>
    @endif

    <!-- Back to Games -->
    <div class="mt-8 text-center">
        <a href="{{ route('casual-games.index') }}" class="text-accent-blue hover:text-accent-blue-bright">
            ← Back to All Games
        </a>
    </div>
</div>
@endsection
