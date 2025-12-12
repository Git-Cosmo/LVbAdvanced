@extends('layouts.app')

@section('title', $user->name . "'s Achievements")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold dark:text-dark-text-bright">{{ $user->name }}'s Achievements</h1>
                    <p class="dark:text-dark-text-secondary mt-1">{{ $stats['completion_rate'] }}% completion rate</p>
                </div>
            </div>
            <a href="{{ route('achievements.index') }}" class="px-4 py-2 dark:bg-dark-bg-tertiary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>All Achievements</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow">
            <div class="text-sm dark:text-dark-text-secondary mb-2">Achievements Unlocked</div>
            <div class="text-3xl font-bold dark:text-dark-text-bright">{{ $stats['total_achievements'] }}</div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow">
            <div class="text-sm dark:text-dark-text-secondary mb-2">Badges Earned</div>
            <div class="text-3xl font-bold text-accent-purple">{{ $stats['total_badges'] }}</div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow">
            <div class="text-sm dark:text-dark-text-secondary mb-2">Total Points</div>
            <div class="text-3xl font-bold text-accent-green">{{ number_format($stats['total_points']) }}</div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow">
            <div class="text-sm dark:text-dark-text-secondary mb-2">Completion Rate</div>
            <div class="text-3xl font-bold text-accent-blue">{{ $stats['completion_rate'] }}%</div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow mb-8">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold dark:text-dark-text-bright">Overall Progress</h3>
            <span class="text-sm dark:text-dark-text-secondary">{{ $stats['total_achievements'] }} / {{ $stats['total_achievements'] + count($lockedAchievements) }}</span>
        </div>
        <div class="w-full bg-gray-700 rounded-full h-4 overflow-hidden">
            <div class="bg-gradient-to-r from-accent-blue to-accent-purple h-full rounded-full transition-all duration-500" style="width: {{ $stats['completion_rate'] }}%"></div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b dark:border-dark-border-primary">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('unlocked')" id="unlocked-tab" class="tab-button border-b-2 border-accent-blue py-4 px-1 text-sm font-medium text-accent-blue">
                    Unlocked ({{ $unlockedAchievements->count() }})
                </button>
                <button onclick="showTab('badges')" id="badges-tab" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium dark:text-dark-text-secondary hover:text-accent-blue hover:border-accent-blue">
                    Badges ({{ $user->badges->count() }})
                </button>
                <button onclick="showTab('locked')" id="locked-tab" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium dark:text-dark-text-secondary hover:text-accent-blue hover:border-accent-blue">
                    Locked ({{ $lockedAchievements->count() }})
                </button>
            </nav>
        </div>
    </div>

    <!-- Unlocked Achievements Tab -->
    <div id="unlocked-content" class="tab-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($unlockedAchievements as $achievement)
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-2 border-accent-green">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center text-white text-2xl">
                                {{ $achievement->icon ?? '🏆' }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold dark:text-dark-text-bright">{{ $achievement->name }}</h3>
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-sm dark:text-dark-text-secondary mb-2">{{ $achievement->description }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-accent-blue font-medium">{{ $achievement->points }} points</span>
                                <span class="text-xs dark:text-dark-text-muted">
                                    Unlocked {{ $achievement->formatted_unlocked_at ?? 'recently' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="dark:text-dark-text-secondary">No achievements unlocked yet. Keep participating to earn achievements!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Badges Tab -->
    <div id="badges-content" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($user->badges as $badge)
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-2 border-accent-purple">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-lg flex items-center justify-center text-white text-2xl" style="background: {{ $badge->color ?? 'linear-gradient(to bottom right, #8B5CF6, #EC4899)' }}">
                                {{ $badge->icon ?? '⭐' }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold dark:text-dark-text-bright mb-1">{{ $badge->name }}</h3>
                            <p class="text-sm dark:text-dark-text-secondary mb-2">{{ $badge->description }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-accent-purple font-medium">{{ $badge->points }} points</span>
                                <span class="text-xs dark:text-dark-text-muted">
                                    Earned {{ $badge->formatted_awarded_at ?? 'recently' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="dark:text-dark-text-secondary">No badges earned yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Locked Achievements Tab -->
    <div id="locked-content" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($lockedAchievements as $achievement)
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 hover:shadow-lg transition-shadow opacity-60">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 text-2xl relative">
                                {{ $achievement->icon ?? '🔒' }}
                                <div class="absolute inset-0 bg-black/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold dark:text-dark-text-bright mb-1">{{ $achievement->name }}</h3>
                            <p class="text-sm dark:text-dark-text-secondary mb-2">{{ $achievement->description }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="dark:text-dark-text-muted font-medium">{{ $achievement->points }} points</span>
                                <span class="text-xs text-yellow-500">Locked</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="dark:text-dark-text-secondary">All achievements unlocked! Amazing work! 🎉</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Reset all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-accent-blue', 'text-accent-blue');
        button.classList.add('border-transparent');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Highlight selected tab button
    const selectedTab = document.getElementById(tabName + '-tab');
    selectedTab.classList.add('border-accent-blue', 'text-accent-blue');
    selectedTab.classList.remove('border-transparent');
}
</script>
@endsection
