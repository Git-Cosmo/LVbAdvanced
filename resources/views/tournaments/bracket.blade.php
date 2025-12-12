@extends('layouts.app')

@section('title', $tournament->name . ' - Bracket')

@section('content')
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright">{{ $tournament->name }}</h1>
                <p class="dark:text-dark-text-secondary mt-2">Tournament Bracket</p>
            </div>
            <a href="{{ route('tournaments.show', $tournament) }}" class="px-4 py-2 dark:bg-dark-bg-secondary rounded-lg dark:text-dark-text-primary hover:bg-dark-bg-tertiary transition-colors">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back to Tournament</span>
                </div>
            </a>
        </div>
    </div>

    @if($rounds->isEmpty())
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-accent-blue to-accent-purple rounded-full flex items-center justify-center opacity-50">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright mb-2">Bracket Not Generated</h3>
            <p class="dark:text-dark-text-secondary">The bracket will be available once registration closes and participants are seeded.</p>
        </div>
    @else
        <!-- Bracket View -->
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6 overflow-x-auto">
            <div class="flex space-x-8 min-w-max">
                @foreach($rounds as $roundNumber => $matches)
                    <div class="flex-shrink-0" style="min-width: 300px;">
                        <h3 class="text-lg font-bold dark:text-dark-text-bright mb-6 text-center">
                            @if($roundNumber == $rounds->keys()->max())
                                Finals
                            @elseif($roundNumber == $rounds->keys()->max() - 1)
                                Semi-Finals
                            @else
                                Round {{ $roundNumber }}
                            @endif
                        </h3>
                        
                        <div class="space-y-6">
                            @foreach($matches as $match)
                                <div class="dark:bg-dark-bg-tertiary rounded-lg p-4 border-2 
                                    {{ $match->status === 'completed' ? 'border-green-600' : '' }}
                                    {{ $match->status === 'in_progress' ? 'border-blue-600' : '' }}
                                    {{ $match->status === 'ready' ? 'border-accent-blue' : 'border-dark-border-primary' }}">
                                    <div class="text-xs dark:text-dark-text-muted mb-3">Match #{{ $match->match_number }}</div>
                                    
                                    <!-- Participant 1 -->
                                    <div class="flex items-center justify-between p-2 rounded 
                                        {{ $match->winner_id === $match->participant1_id ? 'bg-green-600/20' : 'dark:bg-dark-bg-elevated' }} mb-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white text-xs font-bold">
                                                @if($match->participant1)
                                                    {{ $match->participant1->seed ?? '?' }}
                                                @else
                                                    ?
                                                @endif
                                            </div>
                                            <span class="font-medium dark:text-dark-text-primary">
                                                {{ $match->participant1?->display_name ?? 'TBD' }}
                                            </span>
                                        </div>
                                        @if($match->participant1_score !== null)
                                            <span class="font-bold dark:text-dark-text-bright">{{ $match->participant1_score }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-center text-xs dark:text-dark-text-muted mb-2">VS</div>
                                    
                                    <!-- Participant 2 -->
                                    <div class="flex items-center justify-between p-2 rounded 
                                        {{ $match->winner_id === $match->participant2_id ? 'bg-green-600/20' : 'dark:bg-dark-bg-elevated' }}">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-accent-orange to-accent-red flex items-center justify-center text-white text-xs font-bold">
                                                @if($match->participant2)
                                                    {{ $match->participant2->seed ?? '?' }}
                                                @else
                                                    ?
                                                @endif
                                            </div>
                                            <span class="font-medium dark:text-dark-text-primary">
                                                {{ $match->participant2?->display_name ?? 'TBD' }}
                                            </span>
                                        </div>
                                        @if($match->participant2_score !== null)
                                            <span class="font-bold dark:text-dark-text-bright">{{ $match->participant2_score }}</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Match Status -->
                                    <div class="mt-3 text-center">
                                        <span class="text-xs px-2 py-1 rounded
                                            {{ $match->status === 'completed' ? 'bg-green-600 text-white' : '' }}
                                            {{ $match->status === 'in_progress' ? 'bg-blue-600 text-white' : '' }}
                                            {{ $match->status === 'ready' ? 'bg-accent-blue text-white' : '' }}
                                            {{ $match->status === 'pending' ? 'bg-gray-600 text-white' : '' }}">
                                            {{ ucfirst($match->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Legend -->
        <div class="mt-6 dark:bg-dark-bg-secondary rounded-lg shadow p-4">
            <h4 class="font-bold dark:text-dark-text-bright mb-3">Legend</h4>
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded border-2 border-green-600"></div>
                    <span class="dark:text-dark-text-secondary">Completed</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded border-2 border-blue-600"></div>
                    <span class="dark:text-dark-text-secondary">In Progress</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded border-2 border-accent-blue"></div>
                    <span class="dark:text-dark-text-secondary">Ready</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 rounded border-2 border-dark-border-primary"></div>
                    <span class="dark:text-dark-text-secondary">Pending</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
