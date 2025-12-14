@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">🎯 Daily Challenges</h1>
        <p class="dark:text-dark-text-secondary text-lg">Complete daily challenges and earn bonus rewards!</p>
    </div>

    <!-- Challenges Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($challenges as $challenge)
            <div class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-green-500 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright">{{ $challenge->title }}</h3>
                    <span class="px-3 py-1 text-xs font-semibold rounded
                        @if($challenge->type == 'daily') bg-blue-500/20 text-blue-400
                        @elseif($challenge->type == 'weekly') bg-purple-500/20 text-purple-400
                        @else bg-green-500/20 text-green-400
                        @endif">
                        {{ ucfirst($challenge->type) }}
                    </span>
                </div>

                <p class="dark:text-dark-text-secondary mb-4">{{ Str::limit($challenge->description, 120) }}</p>

                <div class="mb-4">
                    <div class="flex justify-between items-center text-sm dark:text-dark-text-tertiary mb-2">
                        <span>Progress</span>
                        <span>{{ $challenge->progress ?? 0 }}/{{ $challenge->goal }}</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all" 
                             style="width: {{ min(100, (($challenge->progress ?? 0) / $challenge->goal) * 100) }}%"></div>
                    </div>
                </div>

                <div class="flex justify-between items-center text-sm dark:text-dark-text-tertiary mb-4">
                    <span>🎁 {{ $challenge->reward_points }} pts</span>
                    @if($challenge->expires_at)
                        <span>⏰ {{ $challenge->expires_at->diffForHumans() }}</span>
                    @endif
                </div>

                <a href="{{ route('casual-games.challenges.show', $challenge) }}" 
                   class="block w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-center py-2 rounded-lg font-semibold transition-all">
                    View Challenge
                </a>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <div class="mb-4 text-6xl">🎯</div>
                <p class="dark:text-dark-text-secondary text-lg mb-2">No active challenges at the moment.</p>
                <p class="dark:text-dark-text-tertiary text-sm">New challenges are added daily. Check back tomorrow!</p>
            </div>
        @endforelse
    </div>

    @if($challenges->hasPages())
        <div class="mt-8">
            {{ $challenges->links() }}
        </div>
    @endif
</div>
@endsection
