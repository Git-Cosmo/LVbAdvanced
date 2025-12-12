@extends('layouts.app')

@section('title', 'Clans & Guilds')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold dark:text-dark-text-bright">Clans & Guilds</h1>
                <p class="dark:text-dark-text-secondary mt-2">Join gaming communities and compete together</p>
            </div>
            @auth
                <button class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Create Clan</span>
                    </div>
                </button>
            @endauth
        </div>
    </div>

    @if($clans->isEmpty())
        <!-- Empty State -->
        <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-accent-orange to-accent-red rounded-full flex items-center justify-center opacity-50">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright mb-2">No Clans Yet</h3>
            <p class="dark:text-dark-text-secondary mb-6 max-w-md mx-auto">
                Be the first to create a clan! Gather players, organize events, and dominate the leaderboards together.
            </p>
            @auth
                <button class="inline-block px-6 py-3 bg-gradient-to-r from-accent-orange to-accent-red text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    Create Your Clan
                </button>
            @else
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-accent-orange to-accent-red text-white rounded-lg font-medium hover:shadow-lg transition-all">
                    Sign In to Create Clan
                </a>
            @endauth
        </div>
    @else
        <!-- Clans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($clans as $clan)
                <a href="{{ route('clans.show', $clan) }}" class="dark:bg-dark-bg-secondary rounded-lg shadow overflow-hidden hover:shadow-xl transition-all group">
                    <!-- Clan Banner -->
                    <div class="h-32 bg-gradient-to-br from-gray-600 to-gray-800 relative overflow-hidden">
                        @if($clan->banner_url ?? false)
                            <img src="{{ $clan->banner_url }}" alt="{{ $clan->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-6xl font-bold text-white/20">
                                    {{ $clan->tag ?? substr($clan->name, 0, 3) }}
                                </div>
                            </div>
                        @endif
                        
                        <!-- Clan Tag Badge -->
                        @if($clan->tag ?? false)
                            <div class="absolute top-4 left-4 px-3 py-1 bg-black/50 backdrop-blur-sm rounded text-white font-bold">
                                {{ $clan->tag }}
                            </div>
                        @endif
                        
                        <!-- Recruiting Badge -->
                        @if($clan->is_recruiting ?? false)
                            <div class="absolute top-4 right-4 px-2 py-1 bg-green-600 rounded text-xs font-medium text-white">
                                Recruiting
                            </div>
                        @endif
                    </div>
                    
                    <!-- Clan Logo -->
                    <div class="relative -mt-8 px-6">
                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-accent-blue to-accent-purple border-4 dark:border-dark-bg-secondary flex items-center justify-center shadow-lg">
                            @if($clan->logo_url ?? false)
                                <img src="{{ $clan->logo_url }}" alt="{{ $clan->name }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <span class="text-2xl font-bold text-white">
                                    {{ substr($clan->name, 0, 1) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Clan Info -->
                    <div class="p-6 pt-2">
                        <h3 class="text-lg font-bold dark:text-dark-text-bright mb-1">
                            {{ $clan->name }}
                        </h3>
                        
                        @if($clan->game ?? false)
                            <p class="text-sm text-accent-blue mb-2">{{ $clan->game }}</p>
                        @endif
                        
                        <p class="dark:text-dark-text-secondary text-sm mb-4 line-clamp-2">
                            {{ $clan->description ?? 'No description provided.' }}
                        </p>
                        
                        <!-- Clan Stats -->
                        <div class="flex items-center justify-between text-sm pt-4 border-t dark:border-dark-border-primary">
                            <div class="flex items-center space-x-2 dark:text-dark-text-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>{{ $clan->members_count }} {{ $clan->members_count === 1 ? 'member' : 'members' }}</span>
                            </div>
                            
                            <div class="flex items-center space-x-2 dark:text-dark-text-muted text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $clan->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $clans->links() }}
        </div>
    @endif
</div>
@endsection
