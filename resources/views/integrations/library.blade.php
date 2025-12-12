@extends('layouts.app')

@section('title', 'Game Library')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright">Game Library</h1>
                <p class="dark:text-dark-text-secondary mt-2">All your games across all platforms</p>
            </div>
            <a href="{{ route('integrations.index') }}" class="px-4 py-2 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back to Dashboard</span>
                </div>
            </a>
        </div>
    </div>

    @if($games->isEmpty())
        <!-- Empty State -->
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-accent-blue to-accent-purple rounded-full flex items-center justify-center opacity-50">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright mb-2">No Games Yet</h3>
            <p class="dark:text-dark-text-secondary mb-6 max-w-md mx-auto">
                Connect your gaming accounts to sync your game library automatically. Your games will appear here once synced.
            </p>
            <a href="{{ route('integrations.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                Connect Platform
            </a>
        </div>
    @else
        <!-- Games Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($games as $game)
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow group">
                    <!-- Game Cover -->
                    <div class="aspect-video bg-gradient-to-br from-gray-700 to-gray-900 relative overflow-hidden">
                        @if($game->cover_url)
                            <img src="{{ $game->cover_url }}" alt="{{ $game->game_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Platform Badge -->
                        <div class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-medium text-white backdrop-blur-sm
                            {{ $game->platform === 'steam' ? 'bg-blue-600/80' : '' }}
                            {{ $game->platform === 'xbox' ? 'bg-green-600/80' : '' }}
                            {{ $game->platform === 'psn' ? 'bg-indigo-600/80' : '' }}">
                            {{ strtoupper($game->platform) }}
                        </div>
                    </div>
                    
                    <!-- Game Info -->
                    <div class="p-4">
                        <h3 class="font-semibold dark:text-dark-text-bright mb-2 truncate" title="{{ $game->game_name }}">
                            {{ $game->game_name }}
                        </h3>
                        
                        <div class="flex items-center justify-between text-sm">
                            <div class="dark:text-dark-text-secondary">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ number_format($game->playtime_minutes / 60, 1) }}h
                            </div>
                            <div class="text-xs dark:text-dark-text-muted">
                                Added {{ $game->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $games->links() }}
        </div>
    @endif
</div>
@endsection
