@extends('layouts.app')

@section('title', 'Tournaments')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright">Tournaments</h1>
                <p class="dark:text-dark-text-secondary mt-2">Compete in organized gaming tournaments</p>
            </div>
            @auth
                <a href="{{ route('tournaments.create') }}" class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Create Tournament</span>
                    </div>
                </a>
            @endauth
        </div>
    </div>

    <!-- Featured Tournaments -->
    @if($featured->isNotEmpty())
        <div class="mb-12">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright mb-6">Featured Tournaments</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featured as $tournament)
                    <div class="dark:bg-dark-bg-secondary rounded-lg shadow-lg overflow-hidden border-2 border-accent-blue">
                        <div class="h-40 bg-gradient-to-br from-accent-blue to-accent-purple relative">
                            @if($tournament->cover_image)
                                <img src="{{ $tournament->cover_image }}" alt="{{ $tournament->name }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-4 right-4 px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                FEATURED
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold dark:text-dark-text-bright mb-2">{{ $tournament->name }}</h3>
                            <p class="text-sm dark:text-dark-text-secondary mb-4 line-clamp-2">{{ $tournament->description }}</p>
                            <div class="flex items-center justify-between text-sm mb-4">
                                <span class="dark:text-dark-text-secondary">{{ $tournament->current_participants }}/{{ $tournament->max_participants }} players</span>
                                @if($tournament->prize_pool)
                                    <span class="text-accent-green font-semibold">${{ number_format($tournament->prize_pool, 0) }}</span>
                                @else
                                    <span class="dark:text-dark-text-secondary">No prize</span>
                                @endif
                            </div>
                            <a href="{{ route('tournaments.show', $tournament) }}" class="block w-full px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white text-center rounded-lg font-medium hover:shadow-lg transition-all">
                                View Tournament
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Filters -->
    <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                    <option value="">All</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Format</label>
                <select name="format" class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
                    <option value="">All Formats</option>
                    <option value="single_elimination" {{ request('format') === 'single_elimination' ? 'selected' : '' }}>Single Elimination</option>
                    <option value="double_elimination" {{ request('format') === 'double_elimination' ? 'selected' : '' }}>Double Elimination</option>
                    <option value="round_robin" {{ request('format') === 'round_robin' ? 'selected' : '' }}>Round Robin</option>
                    <option value="swiss" {{ request('format') === 'swiss' ? 'selected' : '' }}>Swiss</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Game</label>
                <input type="text" name="game" value="{{ request('game') }}" placeholder="Filter by game..." class="w-full px-4 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg border dark:border-dark-border-primary">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-accent-blue text-white rounded-lg font-medium hover:bg-blue-600 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Tournaments List -->
    @if($tournaments->isEmpty())
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-accent-blue to-accent-purple rounded-full flex items-center justify-center opacity-50">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright mb-2">No Tournaments Found</h3>
            <p class="dark:text-dark-text-secondary mb-6">Check back later or create your own tournament!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tournaments as $tournament)
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                    <!-- Tournament Header -->
                    <div class="h-32 bg-gradient-to-br from-gray-700 to-gray-900 relative">
                        @if($tournament->cover_image)
                            <img src="{{ $tournament->cover_image }}" alt="{{ $tournament->name }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute top-2 left-2 px-2 py-1 rounded text-xs font-medium text-white backdrop-blur-sm
                            {{ $tournament->status === 'registration_open' ? 'bg-green-600/80' : '' }}
                            {{ $tournament->status === 'in_progress' ? 'bg-blue-600/80' : '' }}
                            {{ $tournament->status === 'completed' ? 'bg-gray-600/80' : '' }}">
                            {{ str_replace('_', ' ', strtoupper($tournament->status)) }}
                        </div>
                    </div>

                    <!-- Tournament Info -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold dark:text-dark-text-bright mb-2">{{ $tournament->name }}</h3>
                        
                        @if($tournament->game)
                            <p class="text-sm text-accent-blue mb-2">{{ $tournament->game }}</p>
                        @endif

                        <p class="text-sm dark:text-dark-text-secondary mb-4 line-clamp-2">
                            {{ $tournament->description }}
                        </p>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4 pb-4 border-b dark:border-dark-border-primary">
                            <div>
                                <div class="text-xs dark:text-dark-text-secondary">Format</div>
                                <div class="text-sm font-semibold dark:text-dark-text-primary capitalize">
                                    {{ str_replace('_', ' ', $tournament->format) }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs dark:text-dark-text-secondary">Participants</div>
                                <div class="text-sm font-semibold dark:text-dark-text-primary">
                                    {{ $tournament->current_participants }}/{{ $tournament->max_participants }}
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                @if($tournament->prize_pool)
                                    <span class="text-accent-green font-bold">${{ number_format($tournament->prize_pool, 0) }}</span>
                                @else
                                    <span class="dark:text-dark-text-secondary">No prize pool</span>
                                @endif
                            </div>
                            <a href="{{ route('tournaments.show', $tournament) }}" class="px-4 py-2 bg-accent-blue text-white text-sm rounded-lg hover:bg-blue-600 transition-colors">
                                View Details
                            </a>
                        </div>

                        <div class="mt-3 text-xs dark:text-dark-text-muted">
                            Starts: {{ $tournament->starts_at->format('M d, Y g:i A') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $tournaments->links() }}
        </div>
    @endif
</div>
@endsection
