@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <article class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-8">
            <!-- Game Name Badge -->
            <div class="mb-4">
                <span class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-full text-sm font-semibold">
                    {{ $patchNote->game_name }}
                </span>
                @if($patchNote->version)
                    <span class="ml-2 px-3 py-1 bg-gray-200 dark:bg-dark-bg-tertiary rounded text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        Version {{ $patchNote->version }}
                    </span>
                @endif
                @if($patchNote->is_featured)
                    <span class="ml-2 px-3 py-1 bg-accent-orange text-white rounded text-sm font-semibold">
                        Featured
                    </span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                {{ $patchNote->title }}
            </h1>

            <!-- Meta Information -->
            <div class="flex items-center space-x-4 mb-6 pb-6 border-b dark:border-dark-border-primary border-light-border-primary">
                <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    Released {{ $patchNote->released_at ? $patchNote->released_at->format('F d, Y') : 'recently' }}
                </span>
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">•</span>
                <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                    👁 {{ $patchNote->views_count }} views
                </span>
            </div>

            <!-- Description -->
            @if($patchNote->description)
                <div class="text-lg dark:text-dark-text-secondary text-light-text-secondary italic mb-6 pb-6 border-b dark:border-dark-border-primary border-light-border-primary">
                    {{ $patchNote->description }}
                </div>
            @endif

            <!-- Content -->
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($patchNote->content)) !!}
            </div>

            <!-- Source -->
            @if($patchNote->source_url)
                <div class="mt-6 p-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                    <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        Official Patch Notes: <a href="{{ $patchNote->source_url }}" target="_blank" rel="noopener" class="text-accent-blue hover:text-accent-purple font-medium">View on {{ parse_url($patchNote->source_url, PHP_URL_HOST) }}</a>
                    </p>
                </div>
            @endif
        </div>
    </article>

    <!-- Related Patch Notes -->
    @if($relatedPatchNotes->count() > 0)
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                More {{ $patchNote->game_name }} Patch Notes
            </h2>
            <div class="space-y-4">
                @foreach($relatedPatchNotes as $related)
                    <div class="border-l-4 border-primary-600 pl-4">
                        <div class="flex items-center justify-between">
                            <div>
                                @if($related->version)
                                    <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">v{{ $related->version }}</span>
                                @endif
                                <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright">
                                    <a href="{{ route('patch-notes.show', $related) }}" class="hover:text-accent-blue transition-colors">
                                        {{ $related->title }}
                                    </a>
                                </h3>
                                <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                    {{ $related->released_at ? $related->released_at->format('M d, Y') : 'Recently' }}
                                </p>
                            </div>
                            <a href="{{ route('patch-notes.show', $related) }}" class="text-primary-600 hover:text-primary-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('patch-notes.index', ['game' => $patchNote->game_name]) }}" class="text-primary-600 hover:text-primary-800 font-medium">
                    View All {{ $patchNote->game_name }} Patch Notes →
                </a>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('patch-notes.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Patch Notes
        </a>
    </div>
</div>
@endsection
