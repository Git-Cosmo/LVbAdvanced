@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Result Card -->
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-8 text-center">
        <div class="mb-6">
            @if($attempt->status === 'completed')
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">🎉</span>
                </div>
                <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-2">Congratulations!</h1>
                <p class="dark:text-dark-text-secondary">You completed the game!</p>
            @elseif($attempt->status === 'walked_away')
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">👋</span>
                </div>
                <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-2">Smart Move!</h1>
                <p class="dark:text-dark-text-secondary">You walked away with your winnings</p>
            @else
                <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-4xl">😞</span>
                </div>
                <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-2">Game Over</h1>
                <p class="dark:text-dark-text-secondary">Better luck next time!</p>
            @endif
        </div>

        <!-- Prize Won -->
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg p-8 mb-6">
            <div class="text-sm text-white/80 mb-2">You Won</div>
            <div class="text-5xl font-bold text-white">${{ number_format($attempt->prize_won) }}</div>
            <div class="text-sm text-white/80 mt-2">Added to your points!</div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4">
                <div class="text-2xl font-bold dark:text-dark-text-bright">{{ $attempt->current_question - 1 }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Questions Answered</div>
            </div>
            <div class="dark:bg-dark-bg-tertiary rounded-lg p-4">
                <div class="text-2xl font-bold dark:text-dark-text-bright">{{ 3 - count($attempt->lifelines_used ?? []) }}</div>
                <div class="text-sm dark:text-dark-text-tertiary">Lifelines Remaining</div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <a href="{{ route('casual-games.millionaire.show', $game) }}" class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:opacity-90 transition-opacity font-semibold">
                Play Again
            </a>
            <a href="{{ route('casual-games.millionaire.index') }}" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                Back to Games
            </a>
        </div>
    </div>
</div>
@endsection
