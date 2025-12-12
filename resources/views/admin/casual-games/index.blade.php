@extends('admin.layouts.app')

@section('header', 'Casual Games Management')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-dark-text-muted">Trivia Games</p>
                    <p class="text-2xl font-bold dark:text-dark-text-bright mt-1">{{ $stats['trivia_count'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-dark-text-muted">Active Predictions</p>
                    <p class="text-2xl font-bold dark:text-dark-text-bright mt-1">{{ $stats['predictions_count'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-purple-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-dark-text-muted">Daily Challenges</p>
                    <p class="text-2xl font-bold dark:text-dark-text-bright mt-1">{{ $stats['challenges_count'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-dark-text-muted">Total Bets</p>
                    <p class="text-2xl font-bold dark:text-dark-text-bright mt-1">{{ $stats['bets_count'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-2">Trivia Games</h3>
            <p class="text-sm text-gray-500 dark:text-dark-text-muted mb-4">Create and manage trivia games for users to play</p>
            <a href="{{ route('admin.casual-games.trivia.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Manage Trivia
            </a>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-2">Predictions</h3>
            <p class="text-sm text-gray-500 dark:text-dark-text-muted mb-4">Create prediction games for tournaments and events</p>
            <a href="{{ route('admin.casual-games.predictions.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Manage Predictions
            </a>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-2">Daily Challenges</h3>
            <p class="text-sm text-gray-500 dark:text-dark-text-muted mb-4">Set up daily challenges to engage your community</p>
            <a href="{{ route('admin.casual-games.challenges.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                Manage Challenges
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
        <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-4">Recent Activity</h3>
        
        @if(isset($recentActivity) && count($recentActivity) > 0)
            <div class="space-y-4">
                @foreach($recentActivity as $activity)
                    <div class="flex items-center justify-between py-3 border-b dark:border-dark-border-primary last:border-b-0">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 rounded-lg {{ $activity['type_color'] ?? 'bg-gray-500/10' }}">
                                <svg class="w-5 h-5 {{ $activity['icon_color'] ?? 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium dark:text-dark-text-bright">{{ $activity['title'] ?? 'Activity' }}</p>
                                <p class="text-xs text-gray-500 dark:text-dark-text-muted">{{ $activity['description'] ?? '' }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-dark-text-muted">{{ $activity['time'] ?? '' }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 dark:text-dark-text-muted text-center py-4">No recent activity</p>
        @endif
    </div>

    <!-- Points Economy Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-4">Points Economy</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-dark-text-muted">Total Points Awarded</span>
                    <span class="text-sm font-semibold dark:text-dark-text-bright">{{ number_format($stats['total_points_awarded'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-dark-text-muted">Total Points Spent</span>
                    <span class="text-sm font-semibold dark:text-dark-text-bright">{{ number_format($stats['total_points_spent'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-dark-text-muted">Points in Circulation</span>
                    <span class="text-sm font-semibold text-green-500">{{ number_format($stats['points_circulation'] ?? 0) }}</span>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-4">User Engagement</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-dark-text-muted">Active Players (7 days)</span>
                    <span class="text-sm font-semibold dark:text-dark-text-bright">{{ number_format($stats['active_players'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-dark-text-muted">Total Game Plays</span>
                    <span class="text-sm font-semibold dark:text-dark-text-bright">{{ number_format($stats['total_plays'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-dark-text-muted">Avg. Engagement Time</span>
                    <span class="text-sm font-semibold text-blue-500">{{ $stats['avg_engagement_time'] ?? '0m' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
