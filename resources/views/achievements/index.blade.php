@extends('layouts.app')

@section('title', 'Achievements & Badges')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright">Achievements & Badges</h1>
        <p class="dark:text-dark-text-secondary mt-2">Unlock achievements and earn badges by being active in the community</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm dark:text-dark-text-secondary mb-2">Total Achievements</div>
                    <div class="text-3xl font-bold dark:text-dark-text-bright">{{ $stats['total_achievements'] }}</div>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm dark:text-dark-text-secondary mb-2">Total Badges</div>
                    <div class="text-3xl font-bold text-accent-purple">{{ $stats['total_badges'] }}</div>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-accent-purple to-accent-pink rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm dark:text-dark-text-secondary mb-2">Total Unlocks</div>
                    <div class="text-3xl font-bold text-accent-green">{{ number_format($stats['total_unlocks']) }}</div>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-accent-green to-accent-teal rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b dark:border-dark-border-primary">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('achievements')" id="achievements-tab" class="tab-button border-b-2 border-accent-blue py-4 px-1 text-sm font-medium text-accent-blue">
                    Achievements
                </button>
                <button onclick="showTab('badges')" id="badges-tab" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium dark:text-dark-text-secondary hover:text-accent-blue hover:border-accent-blue">
                    Badges
                </button>
                <button onclick="showTab('leaderboard')" id="leaderboard-tab" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium dark:text-dark-text-secondary hover:text-accent-blue hover:border-accent-blue">
                    Top Achievers
                </button>
            </nav>
        </div>
    </div>

    <!-- Achievements Tab -->
    <div id="achievements-content" class="tab-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($achievements as $achievement)
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center text-white text-2xl">
                                {{ $achievement->icon ?? '🏆' }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold dark:text-dark-text-bright mb-1">{{ $achievement->name }}</h3>
                            <p class="text-sm dark:text-dark-text-secondary mb-2">{{ $achievement->description }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-accent-blue font-medium">{{ $achievement->points }} points</span>
                                <span class="dark:text-dark-text-muted">{{ $achievement->users_count }} unlocked</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="dark:text-dark-text-secondary">No achievements available yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Badges Tab -->
    <div id="badges-content" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($badges as $badge)
                <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
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
                                <span class="dark:text-dark-text-muted">{{ $badge->users_count }} earned</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="dark:text-dark-text-secondary">No badges available yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Leaderboard Tab -->
    <div id="leaderboard-content" class="tab-content hidden">
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-xl font-bold dark:text-dark-text-bright mb-6">Top 10 Achievers</h2>
                @forelse($topAchievers as $index => $achiever)
                    <div class="flex items-center justify-between p-4 {{ $index > 0 ? 'border-t dark:border-dark-border-primary' : '' }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-8 text-center">
                                @if($index === 0)
                                    <span class="text-2xl">🥇</span>
                                @elseif($index === 1)
                                    <span class="text-2xl">🥈</span>
                                @elseif($index === 2)
                                    <span class="text-2xl">🥉</span>
                                @else
                                    <span class="text-lg font-bold dark:text-dark-text-secondary">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                {{ substr($achiever->name, 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('profile.show', $achiever) }}" class="font-semibold dark:text-dark-text-bright hover:text-accent-blue">
                                    {{ $achiever->name }}
                                </a>
                                <p class="text-sm dark:text-dark-text-secondary">
                                    {{ $achiever->achievements_count }} {{ $achiever->achievements_count === 1 ? 'achievement' : 'achievements' }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('achievements.user', $achiever) }}" class="px-4 py-2 dark:bg-dark-bg-tertiary rounded-lg text-sm dark:text-dark-text-primary hover:bg-dark-bg-elevated transition-colors">
                            View Profile
                        </a>
                    </div>
                @empty
                    <p class="text-center py-12 dark:text-dark-text-secondary">No data available yet.</p>
                @endforelse
            </div>
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
