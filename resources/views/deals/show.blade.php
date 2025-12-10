@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-48 h-48 rounded-xl overflow-hidden bg-dark-bg-tertiary flex-shrink-0">
            @if($game->thumbnail)
                <img src="{{ $game->thumbnail }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-sm dark:text-dark-text-tertiary text-light-text-tertiary">No Image</div>
            @endif
        </div>
        <div class="flex-1 space-y-3">
            <p class="text-xs uppercase tracking-wide text-accent-blue font-semibold">Game Deals</p>
            <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $game->title }}</h1>
            @if($bestDeal)
                <div class="flex items-center gap-4">
                    <span class="text-3xl font-bold text-accent-green">${{ number_format($bestDeal->sale_price, 2) }}</span>
                    <span class="text-sm line-through dark:text-dark-text-tertiary text-light-text-tertiary">${{ number_format($bestDeal->normal_price, 2) }}</span>
                    @if($bestDeal->savings)
                        <span class="px-3 py-1 rounded-full bg-accent-green/10 text-accent-green font-semibold text-xs">Save {{ number_format($bestDeal->savings, 0) }}%</span>
                    @endif
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ $bestDeal->deal_link }}" target="_blank" rel="noopener" class="px-4 py-2 rounded-lg bg-gradient-to-r from-accent-blue to-accent-purple text-white font-semibold shadow hover:shadow-lg transition">
                        Get Best Deal
                    </a>
                    <a href="{{ route('deals.index') }}" class="px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary font-semibold">
                        Back to deals
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md">
        <div class="px-6 py-4 border-b dark:border-dark-border-primary border-light-border-primary flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright">Available Deals</h2>
                <p class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">All live offers across CheapShark stores</p>
            </div>
            <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">{{ $deals->count() }} offers</span>
        </div>

        <div class="divide-y dark:divide-dark-border-primary divide-light-border-primary">
            @forelse($deals as $deal)
                @php
                    $storeLogo = $deal->store?->logo ? 'https://www.cheapshark.com/' . ltrim($deal->store->logo, '/') : null;
                @endphp
                <div class="px-6 py-4 flex items-center gap-4">
                    @if($storeLogo)
                        <img src="{{ $storeLogo }}" alt="{{ $deal->store?->name }}" class="w-10 h-10 rounded">
                    @else
                        <div class="w-10 h-10 rounded bg-dark-bg-tertiary flex items-center justify-center text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Store</div>
                    @endif
                    <div class="flex-1">
                        <p class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $deal->store?->name ?? 'Unknown Store' }}</p>
                        <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Deal rating: {{ $deal->deal_rating ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-accent-green">${{ number_format($deal->sale_price, 2) }}</div>
                        <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary line-through">${{ number_format($deal->normal_price, 2) }}</div>
                    </div>
                    @if($deal->deal_link)
                        <a href="{{ $deal->deal_link }}" target="_blank" rel="noopener" class="px-4 py-2 rounded-lg bg-accent-blue text-white text-sm font-semibold hover:bg-accent-purple transition">
                            View Deal
                        </a>
                    @endif
                </div>
            @empty
                <div class="px-6 py-8 text-center dark:text-dark-text-secondary text-light-text-secondary">
                    No deals are available for this game yet. Try syncing from the admin panel.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
