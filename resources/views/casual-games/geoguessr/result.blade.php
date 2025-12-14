@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="text-4xl">🗺️</span>
        </div>
        
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-2">Game Complete!</h1>
        <p class="dark:text-dark-text-secondary mb-6">You finished all rounds</p>

        <div class="bg-gradient-to-r from-green-500 to-teal-500 rounded-lg p-8 mb-6">
            <div class="text-sm text-white/80 mb-2">Final Score</div>
            <div class="text-5xl font-bold text-white">{{ number_format($attempt->total_score) }}</div>
            <div class="text-sm text-white/80 mt-2">Points earned!</div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4">
                <div class="text-2xl font-bold dark:text-dark-text-bright">{{ $attempt->rounds_completed }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Rounds Completed</div>
            </div>
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4">
                <div class="text-2xl font-bold dark:text-dark-text-bright">{{ round($attempt->total_score / $attempt->rounds_completed) }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Avg Score per Round</div>
            </div>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('casual-games.geoguessr.show', $game) }}" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                Play Again
            </a>
            <a href="{{ route('casual-games.geoguessr.index') }}" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                Back to Games
            </a>
        </div>
    </div>
</div>
@endsection
