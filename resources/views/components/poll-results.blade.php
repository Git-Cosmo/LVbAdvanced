@props(['poll'])

<div class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-xl p-4">
    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-3">
        📊 {{ $poll->question }}
    </h3>
    
    @php
        $totalVotes = $poll->votes->count();
        $userVote = auth()->check() ? $poll->votes->where('user_id', auth()->id())->first() : null;
    @endphp
    
    <div class="space-y-3">
        @foreach($poll->options as $option)
            @php
                $optionVotes = $poll->votes->where('option_id', $option->id)->count();
                $percentage = $totalVotes > 0 ? round(($optionVotes / $totalVotes) * 100, 1) : 0;
                $isUserChoice = $userVote && $userVote->option_id === $option->id;
            @endphp
            
            <div class="relative">
                <!-- Progress bar background -->
                <div class="relative overflow-hidden rounded-lg dark:bg-dark-bg-secondary bg-light-bg-secondary">
                    <!-- Animated progress fill -->
                    <div 
                        class="h-12 transition-all duration-500 ease-out {{ $isUserChoice ? 'bg-gradient-to-r from-accent-blue to-accent-purple' : 'dark:bg-dark-bg-elevated bg-light-bg-elevated' }}"
                        style="width: {{ $percentage }}%"
                    ></div>
                    
                    <!-- Option text and percentage -->
                    <div class="absolute inset-0 flex items-center justify-between px-4">
                        <div class="flex items-center space-x-2">
                            @if($isUserChoice)
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                            <span class="font-medium {{ $isUserChoice ? 'text-white' : 'dark:text-dark-text-bright text-light-text-bright' }}">
                                {{ $option->option_text }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm font-bold {{ $isUserChoice ? 'text-white' : 'dark:text-dark-text-accent text-light-text-accent' }}">
                                {{ $percentage }}%
                            </span>
                            <span class="text-xs {{ $isUserChoice ? 'text-white opacity-80' : 'dark:text-dark-text-tertiary text-light-text-tertiary' }}">
                                ({{ $optionVotes }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Poll info -->
    <div class="mt-4 pt-4 border-t dark:border-dark-border-primary border-light-border-primary">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center space-x-4">
                <span class="dark:text-dark-text-secondary text-light-text-secondary">
                    <strong class="dark:text-dark-text-bright text-light-text-bright">{{ $totalVotes }}</strong> total votes
                </span>
                @if($poll->is_multiple_choice)
                    <span class="px-2 py-1 rounded text-xs dark:bg-dark-bg-secondary bg-light-bg-secondary dark:text-dark-text-accent text-light-text-accent">
                        Multiple choice
                    </span>
                @endif
            </div>
            
            @if($poll->closes_at)
                <span class="dark:text-dark-text-tertiary text-light-text-tertiary">
                    @if($poll->closes_at->isPast())
                        Closed {{ $poll->closes_at->diffForHumans() }}
                    @else
                        Closes {{ $poll->closes_at->diffForHumans() }}
                    @endif
                </span>
            @endif
        </div>
        
        @auth
            @if(!$userVote && (!$poll->closes_at || $poll->closes_at->isFuture()))
                <a href="#vote" class="mt-3 block text-center px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Vote Now
                </a>
            @elseif($userVote)
                <p class="mt-3 text-center text-sm dark:text-dark-text-accent text-light-text-accent">
                    ✓ You voted for: <strong>{{ $userVote->option->option_text }}</strong>
                </p>
            @endif
        @else
            <a href="{{ route('login') }}" class="mt-3 block text-center px-4 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary dark:text-dark-text-primary text-light-text-primary rounded-lg hover:opacity-80 transition-opacity">
                Sign in to vote
            </a>
        @endauth
    </div>
</div>
