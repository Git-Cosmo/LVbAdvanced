@extends('layouts.app')

@section('title', 'Recently Played')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright">Recently Played</h1>
                <p class="dark:text-dark-text-secondary mt-2">Your latest gaming activity</p>
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

    @if($recentGames->isEmpty())
        <!-- Empty State -->
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-accent-green to-accent-teal rounded-full flex items-center justify-center opacity-50">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright mb-2">No Recent Activity</h3>
            <p class="dark:text-dark-text-secondary mb-6 max-w-md mx-auto">
                Start playing games to see your recent activity here. Once you play games, they'll appear in this timeline.
            </p>
            <a href="{{ route('integrations.library') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-accent-green to-accent-teal text-white rounded-lg font-medium hover:shadow-lg transition-all">
                View Game Library
            </a>
        </div>
    @else
        <!-- Activity Timeline -->
        <div class="space-y-4">
            @foreach($recentGames as $recent)
                @php
                    $game = $recent->gameLibrary;
                    $hoursAgo = $recent->last_played_at->diffInHours(now());
                    $daysAgo = $recent->last_played_at->diffInDays(now());
                @endphp
                
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 hover:shadow-lg transition-all group">
                    <div class="flex items-start space-x-4">
                        <!-- Game Icon/Cover -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-gray-700 to-gray-900 overflow-hidden">
                                @if($game && $game->cover_url)
                                    <img src="{{ $game->cover_url }}" alt="{{ $game->game_name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Game Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg dark:text-dark-text-bright truncate">
                                        {{ $game ? $game->game_name : 'Unknown Game' }}
                                    </h3>
                                    <p class="text-sm dark:text-dark-text-secondary mt-1">
                                        @if($hoursAgo < 1)
                                            Played just now
                                        @elseif($hoursAgo < 24)
                                            Played {{ $hoursAgo }} {{ $hoursAgo === 1 ? 'hour' : 'hours' }} ago
                                        @else
                                            Played {{ $daysAgo }} {{ $daysAgo === 1 ? 'day' : 'days' }} ago
                                        @endif
                                    </p>
                                </div>
                                
                                <!-- Platform Badge -->
                                @if($game)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium text-white
                                        {{ $game->platform === 'steam' ? 'bg-blue-600' : '' }}
                                        {{ $game->platform === 'xbox' ? 'bg-green-600' : '' }}
                                        {{ $game->platform === 'psn' ? 'bg-indigo-600' : '' }}">
                                        {{ strtoupper($game->platform) }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Session Info -->
                            <div class="mt-4 flex items-center space-x-6 text-sm">
                                @if($recent->session_minutes)
                                    <div class="flex items-center space-x-2 dark:text-dark-text-secondary">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Session: {{ number_format($recent->session_minutes / 60, 1) }}h</span>
                                    </div>
                                @endif
                                
                                @if($game && $game->playtime_minutes)
                                    <div class="flex items-center space-x-2 dark:text-dark-text-secondary">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                        <span>Total: {{ number_format($game->playtime_minutes / 60, 1) }}h</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center space-x-2 text-xs dark:text-dark-text-muted">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $recent->last_played_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
