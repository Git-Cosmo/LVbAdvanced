@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold dark:text-dark-text-bright mb-4">🔮 Predictions</h1>
        <p class="dark:text-dark-text-secondary text-lg">Make predictions on gaming events and earn rewards!</p>
    </div>

    <!-- Predictions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($predictions as $prediction)
            <div class="dark:bg-dark-bg-secondary rounded-lg p-6 border dark:border-dark-border-primary hover:border-purple-500 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold dark:text-dark-text-bright">{{ $prediction->title }}</h3>
                    <span class="px-3 py-1 text-xs font-semibold rounded
                        @if($prediction->status == 'open') bg-green-500/20 text-green-400
                        @elseif($prediction->status == 'closed') bg-yellow-500/20 text-yellow-400
                        @else bg-gray-500/20 text-gray-400
                        @endif">
                        {{ ucfirst($prediction->status) }}
                    </span>
                </div>

                <p class="dark:text-dark-text-secondary mb-4">{{ Str::limit($prediction->description, 120) }}</p>

                <div class="flex justify-between items-center text-sm dark:text-dark-text-tertiary mb-4">
                    <span>📊 {{ $prediction->total_entries ?? 0 }} predictions</span>
                    <span>🎁 {{ $prediction->reward_points }} pts</span>
                </div>

                @if($prediction->closes_at)
                    <div class="text-sm dark:text-dark-text-tertiary mb-4">
                        <span class="flex items-center">
                            ⏰ Closes: {{ $prediction->closes_at->format('M d, Y H:i') }}
                        </span>
                    </div>
                @endif

                <a href="{{ route('casual-games.predictions.show', $prediction) }}" 
                   class="block w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white text-center py-2 rounded-lg font-semibold transition-all">
                    Make Prediction
                </a>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <div class="mb-4 text-6xl">🔮</div>
                <p class="dark:text-dark-text-secondary text-lg mb-2">No active predictions at the moment.</p>
                <p class="dark:text-dark-text-tertiary text-sm">Check back soon for new prediction opportunities!</p>
            </div>
        @endforelse
    </div>

    @if($predictions->hasPages())
        <div class="mt-8">
            {{ $predictions->links() }}
        </div>
    @endif
</div>
@endsection
