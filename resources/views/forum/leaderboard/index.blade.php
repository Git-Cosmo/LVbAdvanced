@extends('portal.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ activeTab: 'xp' }">
    <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-8">
        🏆 Leaderboards
    </h1>
    
    <!-- Tab Navigation -->
    <div class="flex space-x-2 mb-6 bg-white dark:bg-gray-800 rounded-lg p-2">
        <button @click="activeTab = 'xp'" 
                :class="activeTab === 'xp' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                class="flex-1 px-6 py-3 rounded-lg font-medium transition">
            💎 Top by XP
        </button>
        <button @click="activeTab = 'level'" 
                :class="activeTab === 'level' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                class="flex-1 px-6 py-3 rounded-lg font-medium transition">
            ⭐ Top by Level
        </button>
        <button @click="activeTab = 'karma'" 
                :class="activeTab === 'karma' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                class="flex-1 px-6 py-3 rounded-lg font-medium transition">
            ❤️ Top by Karma
        </button>
        <button @click="activeTab = 'posts'" 
                :class="activeTab === 'posts' ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300'"
                class="flex-1 px-6 py-3 rounded-lg font-medium transition">
            💬 Top by Posts
        </button>
    </div>
    
    <!-- Top by XP -->
    <div x-show="activeTab === 'xp'" class="space-y-2">
        @foreach($topByXP as $index => $profile)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center hover:shadow-lg transition">
                <div class="text-3xl font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'text-gray-500 dark:text-gray-400')) }} w-16 text-center">
                    #{{ $index + 1 }}
                </div>
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl mx-6">
                    {{ substr($profile->user->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <a href="{{ route('profile.show', $profile->user) }}" 
                       class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright hover:text-purple-600 dark:hover:text-purple-400">
                        {{ $profile->user->name }}
                    </a>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Level {{ $profile->level }}</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                        {{ number_format($profile->xp) }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">XP</div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Top by Level -->
    <div x-show="activeTab === 'level'" class="space-y-2" x-cloak>
        @foreach($topByLevel as $index => $profile)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center hover:shadow-lg transition">
                <div class="text-3xl font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'text-gray-500 dark:text-gray-400')) }} w-16 text-center">
                    #{{ $index + 1 }}
                </div>
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl mx-6">
                    {{ substr($profile->user->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <a href="{{ route('profile.show', $profile->user) }}" 
                       class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright hover:text-purple-600 dark:hover:text-purple-400">
                        {{ $profile->user->name }}
                    </a>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($profile->xp) }} XP</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-yellow-500">
                        {{ $profile->level }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Level</div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Top by Karma -->
    <div x-show="activeTab === 'karma'" class="space-y-2" x-cloak>
        @foreach($topByKarma as $index => $profile)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center hover:shadow-lg transition">
                <div class="text-3xl font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'text-gray-500 dark:text-gray-400')) }} w-16 text-center">
                    #{{ $index + 1 }}
                </div>
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl mx-6">
                    {{ substr($profile->user->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <a href="{{ route('profile.show', $profile->user) }}" 
                       class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright hover:text-purple-600 dark:hover:text-purple-400">
                        {{ $profile->user->name }}
                    </a>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Level {{ $profile->level }}</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-red-500">
                        {{ number_format($profile->karma) }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Karma</div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Top by Posts -->
    <div x-show="activeTab === 'posts'" class="space-y-2" x-cloak>
        @foreach($topByPosts as $index => $user)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center hover:shadow-lg transition">
                <div class="text-3xl font-bold {{ $index === 0 ? 'text-yellow-500' : ($index === 1 ? 'text-gray-400' : ($index === 2 ? 'text-orange-600' : 'text-gray-500 dark:text-gray-400')) }} w-16 text-center">
                    #{{ $index + 1 }}
                </div>
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl mx-6">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <a href="{{ route('profile.show', $user) }}" 
                       class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright hover:text-purple-600 dark:hover:text-purple-400">
                        {{ $user->name }}
                    </a>
                    @if($user->profile)
                        <p class="text-sm text-gray-500 dark:text-gray-400">Level {{ $user->profile->level }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ number_format($user->posts_count) }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Posts</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
