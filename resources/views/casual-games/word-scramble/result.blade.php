@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="text-4xl">📝</span>
        </div>
        
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-2">Game Complete!</h1>
        <p class="dark:text-dark-text-secondary mb-6">Great job on completing the word scramble!</p>

        <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg p-8 mb-6">
            <div class="text-sm text-white/80 mb-2">Final Score</div>
            <div class="text-5xl font-bold text-white">{{ number_format($attempt->total_score) }}</div>
            <div class="text-sm text-white/80 mt-2">Points earned!</div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4">
                <div class="text-3xl font-bold text-green-500">{{ $attempt->words_solved }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Words Solved</div>
            </div>
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4">
                <div class="text-3xl font-bold text-yellow-500">{{ count($attempt->skipped_words ?? []) }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Words Skipped</div>
            </div>
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4">
                <div class="text-3xl font-bold text-blue-500">{{ $attempt->hints_used }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Hints Used</div>
            </div>
        </div>

        <!-- Performance Stats -->
        @if($attempt->words_solved > 0)
        <div class="dark:bg-dark-bg-tertiary rounded-lg p-6 mb-6">
            <h3 class="font-semibold dark:text-dark-text-bright mb-4">Performance</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="dark:text-dark-text-tertiary">Avg Points per Word</div>
                    <div class="text-xl font-bold text-purple-500">{{ number_format($attempt->total_score / $attempt->words_solved) }}</div>
                </div>
                <div>
                    <div class="dark:text-dark-text-tertiary">Success Rate</div>
                    <div class="text-xl font-bold text-green-500">
                        {{ number_format(($attempt->words_solved / ($attempt->words_solved + count($attempt->skipped_words ?? []))) * 100, 1) }}%
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('casual-games.word-scramble.show', $game) }}" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                Play Again
            </a>
            <a href="{{ route('casual-games.word-scramble.index') }}" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                Back to Games
            </a>
        </div>

        <!-- Share hint -->
        <div class="mt-6 text-sm dark:text-dark-text-tertiary">
            Share your score with friends and challenge them to beat it!
        </div>
    </div>
</div>
@endsection
