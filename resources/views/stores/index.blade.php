@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-wide text-accent-blue font-semibold mb-2">Game Stores</p>
                <h1 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">Browse All Gaming Stores</h1>
                <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mt-1">
                    Discover deals from {{ number_format($totalStores) }} stores tracked by CheapShark
                </p>
            </div>
            <a href="{{ route('games.deals') }}" class="px-4 py-2 rounded-lg bg-gradient-to-r from-accent-blue to-accent-purple text-white text-sm font-semibold shadow hover:shadow-lg transition">
                View All Deals
            </a>
        </div>

        <!-- Search and Filter Form -->
        <form method="GET" class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary mb-2">Search stores</label>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search by store name..." class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide dark:text-dark-text-tertiary text-light-text-tertiary mb-2">Sort By</label>
                <select name="sort" class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                    <option value="name" @selected($sortBy === 'name')>Name (A-Z)</option>
                    <option value="deals" @selected($sortBy === 'deals')>Most Deals</option>
                </select>
            </div>
            <div class="flex items-end">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="active" value="1" @checked($filterActive) class="w-5 h-5 rounded dark:bg-dark-bg-tertiary bg-light-bg-tertiary focus:ring-2 focus:ring-accent-blue">
                    <span class="text-sm dark:text-dark-text-primary text-light-text-primary">Active only</span>
                </label>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-semibold hover:shadow-lg transition">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Total Stores</p>
                    <p class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ number_format($totalStores) }}</p>
                </div>
            </div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-accent-green to-accent-blue flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Active Stores</p>
                    <p class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ number_format($activeStores) }}</p>
                </div>
            </div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-accent-purple to-accent-red flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Total Deals</p>
                    <p class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ number_format($totalDeals) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stores Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($stores as $store)
            @php
                $storeLogo = \App\Helpers\CheapSharkHelper::logoUrl($store->logo);
            @endphp
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <!-- Store Header -->
                <div class="relative h-32 bg-gradient-to-br from-accent-blue/20 to-accent-purple/20 flex items-center justify-center p-4">
                    @if($storeLogo)
                        <img src="{{ $storeLogo }}" alt="{{ $store->name }}" class="max-w-full max-h-full object-contain filter group-hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center">
                            <span class="text-2xl font-bold text-white">{{ substr($store->name, 0, 1) }}</span>
                        </div>
                    @endif
                    @if($store->is_active)
                        <span class="absolute top-2 right-2 px-2 py-1 text-xs rounded-full bg-accent-green/20 text-accent-green font-semibold">
                            Active
                        </span>
                    @else
                        <span class="absolute top-2 right-2 px-2 py-1 text-xs rounded-full bg-dark-text-tertiary/20 dark:text-dark-text-tertiary text-light-text-tertiary font-semibold">
                            Inactive
                        </span>
                    @endif
                </div>

                <!-- Store Info -->
                <div class="p-4 space-y-3">
                    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright truncate">{{ $store->name }}</h3>
                    
                    <!-- Stats -->
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="dark:text-dark-text-secondary text-light-text-secondary">
                                <span class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ number_format($store->deals_count) }}</span> deals
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('games.deals', ['store' => $store->cheapshark_id]) }}" class="block w-full px-4 py-2 text-center bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        View Deals
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-8 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">No stores found</p>
                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                    @if($search)
                        Try adjusting your search or filters.
                    @else
                        Run a sync from the admin panel to import stores from CheapShark.
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($stores->hasPages())
        <div class="mt-6">
            {{ $stores->links() }}
        </div>
    @endif
</div>
@endsection
