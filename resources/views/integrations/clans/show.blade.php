@extends('layouts.app')

@section('title', $clan->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Clan Header -->
    <div class="dark:bg-dark-bg-secondary rounded-lg shadow overflow-hidden mb-8">
        <!-- Banner -->
        <div class="h-48 bg-gradient-to-br from-gray-600 to-gray-800 relative overflow-hidden">
            @if($clan->banner_url ?? false)
                <img src="{{ $clan->banner_url }}" alt="{{ $clan->name }}" class="w-full h-full object-cover">
            @else
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-9xl font-bold text-white/10">
                        {{ $clan->tag ?? substr($clan->name, 0, 3) }}
                    </div>
                </div>
            @endif
            
            <!-- Back Button -->
            <a href="{{ route('clans.index') }}" class="absolute top-4 left-4 px-3 py-2 bg-black/50 backdrop-blur-sm rounded text-white hover:bg-black/70 transition-colors">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back</span>
                </div>
            </a>
            
            <!-- Clan Tag -->
            @if($clan->tag ?? false)
                <div class="absolute top-4 right-4 px-4 py-2 bg-black/50 backdrop-blur-sm rounded text-white text-xl font-bold">
                    {{ $clan->tag }}
                </div>
            @endif
        </div>
        
        <!-- Clan Info -->
        <div class="p-8">
            <div class="flex items-start space-x-6">
                <!-- Clan Logo -->
                <div class="flex-shrink-0 -mt-16">
                    <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-accent-blue to-accent-purple border-4 dark:border-dark-bg-secondary flex items-center justify-center shadow-xl">
                        @if($clan->logo_url ?? false)
                            <img src="{{ $clan->logo_url }}" alt="{{ $clan->name }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <span class="text-4xl font-bold text-white">
                                {{ substr($clan->name, 0, 1) }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Clan Details -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold dark:text-dark-text-bright mb-2">{{ $clan->name }}</h1>
                    
                    @if($clan->game ?? false)
                        <p class="text-accent-blue font-medium mb-4">{{ $clan->game }}</p>
                    @endif
                    
                    <p class="dark:text-dark-text-secondary mb-4">
                        {{ $clan->description ?? 'No description provided.' }}
                    </p>
                    
                    <div class="flex items-center space-x-6 text-sm dark:text-dark-text-secondary">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>{{ $clan->members->count() }} members</span>
                        </div>
                        
                        @if($clan->member_limit ?? false)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Limit: {{ $clan->member_limit }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Created {{ $clan->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex-shrink-0">
                    @auth
                        <button class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                            Join Clan
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg transition-all">
                            Sign In to Join
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b dark:border-dark-border-primary">
            <nav class="-mb-px flex space-x-8">
                <a href="#members" class="border-b-2 border-accent-blue py-4 px-1 text-sm font-medium text-accent-blue">
                    Members
                </a>
                <a href="#forums" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium dark:text-dark-text-secondary hover:text-accent-blue hover:border-accent-blue">
                    Forums
                </a>
                <a href="#events" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium dark:text-dark-text-secondary hover:text-accent-blue hover:border-accent-blue">
                    Events
                </a>
            </nav>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Members List -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h2 class="text-xl font-bold dark:text-dark-text-bright mb-6">Clan Members</h2>
                
                @if($clan->members->isEmpty())
                    <p class="dark:text-dark-text-secondary text-center py-8">No members yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($clan->members as $member)
                            <div class="flex items-center justify-between p-4 dark:bg-dark-bg-tertiary rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold">
                                        {{ substr($member->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold dark:text-dark-text-bright">
                                            {{ $member->user->name }}
                                        </div>
                                        <div class="text-sm text-accent-blue capitalize">
                                            {{ $member->role }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm dark:text-dark-text-secondary">
                                    Joined {{ $member->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Clan Leader -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h3 class="font-bold dark:text-dark-text-bright mb-4">Clan Leader</h3>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-orange to-accent-red flex items-center justify-center text-white font-bold">
                        {{ substr($clan->owner->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold dark:text-dark-text-bright">
                            {{ $clan->owner->name }}
                        </div>
                        <div class="text-sm dark:text-dark-text-secondary">
                            Owner
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="dark:bg-dark-bg-secondary rounded-lg shadow p-6">
                <h3 class="font-bold dark:text-dark-text-bright mb-4">Quick Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Status:</span>
                        <span class="font-medium {{ ($clan->is_public ?? true) ? 'text-green-500' : 'text-yellow-500' }}">
                            {{ ($clan->is_public ?? true) ? 'Public' : 'Private' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Recruiting:</span>
                        <span class="font-medium {{ ($clan->is_recruiting ?? true) ? 'text-green-500' : 'text-red-500' }}">
                            {{ ($clan->is_recruiting ?? true) ? 'Open' : 'Closed' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Forums:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $clan->forums->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="dark:text-dark-text-secondary">Events:</span>
                        <span class="font-medium dark:text-dark-text-bright">{{ $clan->events->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
