@extends('layouts.app')

@section('title', 'Leaderboards')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">🏆 Leaderboards</h1>
        <p class="dark:text-dark-text-tertiary text-light-text-tertiary">Top performers across the community</p>
    </div>

    <!-- Leaderboard Tabs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top by XP -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
            <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 flex items-center">
                <span class="text-2xl mr-2">⭐</span> Top by XP
            </h2>
            <div class="space-y-3">
                @foreach($topByXp as $index => $user)
                    <div class="flex items-center p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                        <div class="flex items-center flex-1">
                            <span class="w-8 text-center font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'dark:text-dark-text-tertiary text-light-text-tertiary')) }}">
                                #{{ $index + 1 }}
                            </span>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold ml-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $user->name }}</div>
                                @if($user->profile && $user->profile->user_title)
                                    <div class="text-xs text-accent-blue">{{ $user->profile->user_title }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-accent-purple">{{ number_format($user->profile->xp ?? 0) }}</div>
                            <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">XP</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top by Level -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
            <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 flex items-center">
                <span class="text-2xl mr-2">📊</span> Top by Level
            </h2>
            <div class="space-y-3">
                @foreach($topByLevel as $index => $user)
                    <div class="flex items-center p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                        <div class="flex items-center flex-1">
                            <span class="w-8 text-center font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'dark:text-dark-text-tertiary text-light-text-tertiary')) }}">
                                #{{ $index + 1 }}
                            </span>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold ml-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $user->name }}</div>
                                @if($user->profile && $user->profile->user_title)
                                    <div class="text-xs text-accent-blue">{{ $user->profile->user_title }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-accent-blue">Level {{ $user->profile->level ?? 1 }}</div>
                            <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">{{ number_format($user->profile->xp ?? 0) }} XP</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top by Karma -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
            <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 flex items-center">
                <span class="text-2xl mr-2">💚</span> Top by Karma
            </h2>
            <div class="space-y-3">
                @foreach($topByKarma as $index => $user)
                    <div class="flex items-center p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                        <div class="flex items-center flex-1">
                            <span class="w-8 text-center font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'dark:text-dark-text-tertiary text-light-text-tertiary')) }}">
                                #{{ $index + 1 }}
                            </span>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold ml-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $user->name }}</div>
                                @if($user->profile && $user->profile->user_title)
                                    <div class="text-xs text-accent-blue">{{ $user->profile->user_title }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-green-500">{{ number_format($user->profile->karma ?? 0) }}</div>
                            <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Karma</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Posters -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6">
            <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 flex items-center">
                <span class="text-2xl mr-2">💬</span> Top Posters
            </h2>
            <div class="space-y-3">
                @foreach($topPosters as $index => $user)
                    <div class="flex items-center p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                        <div class="flex items-center flex-1">
                            <span class="w-8 text-center font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'dark:text-dark-text-tertiary text-light-text-tertiary')) }}">
                                #{{ $index + 1 }}
                            </span>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold ml-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $user->name }}</div>
                                @if($user->profile && $user->profile->user_title)
                                    <div class="text-xs text-accent-blue">{{ $user->profile->user_title }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold dark:text-dark-text-bright text-light-text-bright">{{ number_format($user->posts_count) }}</div>
                            <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Posts</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Most Achievements -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-6 lg:col-span-2">
            <h2 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 flex items-center">
                <span class="text-2xl mr-2">🏅</span> Most Achievements
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($topByAchievements as $index => $user)
                    <div class="flex items-center p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                        <div class="flex items-center flex-1">
                            <span class="w-8 text-center font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'dark:text-dark-text-tertiary text-light-text-tertiary')) }}">
                                #{{ $index + 1 }}
                            </span>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold ml-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="font-medium dark:text-dark-text-bright text-light-text-bright">{{ $user->name }}</div>
                                @if($user->profile && $user->profile->user_title)
                                    <div class="text-xs text-accent-blue">{{ $user->profile->user_title }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-yellow-500">{{ $user->achievements_count }}</div>
                            <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Achievements</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
