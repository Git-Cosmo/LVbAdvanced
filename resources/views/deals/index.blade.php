@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-wide text-accent-blue font-semibold mb-2">CheapShark Deals</p>
                <h1 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">Find the best game deals right now</h1>
                <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mt-1">
                    Live prices from CheapShark stores with fast search and smart filtering.
                </p>
            </div>
            <a href="{{ route('activity.trending') }}" class="px-4 py-2 rounded-lg bg-gradient-to-r from-accent-blue to-accent-purple text-white text-sm font-semibold shadow hover:shadow-lg transition">
                Back to community
            </a>
        </div>

        <form method="GET" class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary mb-2">Search games</label>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search by title" class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary mb-2">Store</label>
                <select name="store" class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                    <option value="">All Stores</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->cheapshark_id }}" @selected($storeFilter === $store->cheapshark_id)>{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-semibold hover:shadow-lg transition">
                    Search Deals
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($deals as $deal)
            @php
                $game = $deal->game;
                $store = $deal->store;
                $storeLogo = $store?->logo ? 'https://www.cheapshark.com/' . ltrim($store->logo, '/') : null;
            @endphp
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-4 flex gap-4">
                <div class="w-20 h-20 rounded-lg overflow-hidden bg-dark-bg-tertiary flex-shrink-0">
                    @if($game?->thumbnail)
                        <img src="{{ $game->thumbnail }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xs dark:text-dark-text-tertiary text-light-text-tertiary">No Image</div>
                    @endif
                </div>
                <div class="flex-1 space-y-2">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright line-clamp-1">{{ $game?->title ?? 'Unknown Game' }}</h3>
                        @if($storeLogo)
                            <img src="{{ $storeLogo }}" alt="{{ $store?->name }}" class="w-8 h-8 rounded">
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl font-bold text-accent-green">${{ number_format($deal->sale_price, 2) }}</span>
                        <span class="text-sm line-through dark:text-dark-text-tertiary text-light-text-tertiary">${{ number_format($deal->normal_price, 2) }}</span>
                        @if($deal->savings)
                            <span class="px-2 py-1 text-xs rounded bg-accent-green/10 text-accent-green font-semibold">-{{ number_format($deal->savings, 0) }}%</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs dark:text-dark-text-secondary text-light-text-secondary">Store: {{ $store?->name ?? 'Unknown' }}</span>
                        <div class="flex gap-2">
                            @if($deal->deal_link)
                                <a href="{{ $deal->deal_link }}" target="_blank" rel="noopener" class="text-xs text-accent-blue hover:text-accent-purple font-semibold">View Deal</a>
                            @endif
                            @if($game)
                                <a href="{{ route('deals.show', $game->slug) }}" class="text-xs dark:text-dark-text-accent text-light-text-accent font-semibold">Game Page</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 text-center">
                <p class="dark:text-dark-text-secondary text-light-text-secondary">No deals found. Try running a sync from the admin panel.</p>
            </div>
        @endforelse
    </div>

    <div>
        {{ $deals->links() }}
    </div>
</div>
@endsection
