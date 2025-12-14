@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">🗺️ GeoGuessr Games</h1>
        <p class="dark:text-dark-text-secondary text-lg">Guess the location and test your geography knowledge!</p>
    </div>

    @if($games->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($games as $game)
                <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary overflow-hidden hover:border-accent-green transition-colors">
                    <div class="p-6">
                        <h3 class="font-semibold dark:text-dark-text-bright mb-2">{{ $game->title }}</h3>
                        <p class="dark:text-dark-text-secondary text-sm mb-4">{{ Str::limit($game->description, 100) }}</p>
                        <div class="flex items-center justify-between text-sm dark:text-dark-text-tertiary mb-4">
                            <span>{{ $game->rounds }} rounds</span>
                            <span>{{ $game->time_per_round }}s each</span>
                        </div>
                        <a href="{{ route('casual-games.geoguessr.show', $game) }}" class="block w-full text-center px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:opacity-90 transition-opacity">
                            Play Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if($games->hasPages())
            <div class="mt-8">
                {{ $games->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-4xl">🗺️</span>
            </div>
            <h3 class="text-2xl font-bold dark:text-dark-text-bright mb-2">No Games Available</h3>
            <p class="dark:text-dark-text-secondary">Check back soon for new GeoGuessr games!</p>
        </div>
    @endif

    <div class="mt-8 text-center">
        <a href="{{ route('casual-games.index') }}" class="text-accent-blue hover:text-accent-blue-bright">
            ← Back to All Games
        </a>
    </div>
</div>
@endsection
