@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                    📊 Poll Results
                </h1>
                <h2 class="text-xl dark:text-dark-text-primary text-light-text-primary">
                    {{ $poll->question }}
                </h2>
            </div>
            @if(!$poll->isActive())
                <span class="px-3 py-1 text-xs font-medium bg-accent-red text-white rounded-full">
                    Closed
                </span>
            @else
                <span class="px-3 py-1 text-xs font-medium bg-accent-green text-white rounded-full">
                    Active
                </span>
            @endif
        </div>
        
        @if($poll->thread)
            <a href="{{ route('forum.thread.show', $poll->thread->slug) }}" 
               class="text-sm text-accent-blue hover:underline">
                ← Back to thread
            </a>
        @endif
    </div>
    
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        <div class="space-y-4 mb-6">
            @foreach($poll->options as $option)
                @php
                    $percentage = $poll->total_votes > 0 
                        ? round(($option->votes / $poll->total_votes) * 100, 1) 
                        : 0;
                    $isUserChoice = in_array($option->id, $userVotes);
                @endphp
                <div class="p-4 rounded-lg {{ $isUserChoice ? 'dark:bg-accent-blue/10 bg-accent-blue/5 border-2 border-accent-blue' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary' }}">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium dark:text-dark-text-primary text-light-text-primary">
                                {{ $option->option_text }}
                            </span>
                            @if($isUserChoice)
                                <span class="text-xs text-accent-blue font-semibold">
                                    ✓ Your vote
                                </span>
                            @endif
                        </div>
                        <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                            {{ $option->votes }} votes ({{ $percentage }}%)
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                        <div class="bg-gradient-to-r from-accent-blue to-accent-purple h-4 rounded-full transition-all duration-500 flex items-center justify-end pr-2" 
                             style="width: {{ $percentage }}%">
                            @if($percentage > 10)
                                <span class="text-xs text-white font-semibold">{{ $percentage }}%</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="pt-4 border-t dark:border-dark-border-primary border-light-border-primary">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        <strong>Total votes:</strong> {{ $poll->total_votes }}
                    </div>
                    @if($poll->is_multiple_choice)
                        <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            Multiple choices allowed
                        </div>
                    @endif
                    @if($poll->closes_at)
                        <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            {{ $poll->isActive() ? 'Closes' : 'Closed' }}: {{ $poll->closes_at->format('M d, Y H:i') }}
                        </div>
                    @endif
                </div>
                
                @if($hasVoted)
                    <div class="flex items-center space-x-2 text-sm text-accent-green">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">You have voted in this poll</span>
                    </div>
                @elseif($poll->isActive())
                    <a href="{{ route('forum.thread.show', $poll->thread->slug) }}" 
                       class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all font-medium">
                        Vote Now
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
