<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
            📊 {{ $poll->question }}
        </h3>
        @if(!$poll->isActive())
            <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-full">
                Closed
            </span>
        @endif
    </div>
    
    @php
        $hasVoted = auth()->check() && \App\Models\Forum\ForumPollVote::where('poll_id', $poll->id)
            ->where('user_id', auth()->id())
            ->exists();
    @endphp
    
    @if($hasVoted || !$poll->isActive())
        {{-- Show results --}}
        <div class="space-y-4">
            @foreach($poll->options as $option)
                @php
                    $percentage = $poll->total_votes > 0 
                        ? round(($option->votes / $poll->total_votes) * 100, 1) 
                        : 0;
                @endphp
                <div>
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $option->option_text }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $option->votes }} votes ({{ $percentage }}%)
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-4 rounded-full transition-all duration-500" 
                             style="width: {{ $percentage }}%">
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                Total votes: {{ $poll->total_votes }}
                @if($poll->closes_at)
                    <span class="ml-4">
                        Closes: {{ $poll->closes_at->format('M d, Y H:i') }}
                    </span>
                @endif
            </div>
            
            @if($hasVoted)
                <div class="text-sm text-green-600 dark:text-green-400">
                    ✓ You have voted in this poll
                </div>
            @endif
        </div>
    @else
        {{-- Voting form --}}
        @auth
            <form action="{{ route('forum.poll.vote', $poll) }}" method="POST">
                @csrf
                <div class="space-y-3">
                    @foreach($poll->options as $option)
                        <label class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer transition">
                            @if($poll->is_multiple_choice)
                                <input type="checkbox" 
                                       name="option_ids[]" 
                                       value="{{ $option->id }}"
                                       class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                            @else
                                <input type="radio" 
                                       name="option_ids" 
                                       value="{{ $option->id }}"
                                       class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 focus:ring-purple-500">
                            @endif
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $option->option_text }}
                            </span>
                        </label>
                    @endforeach
                </div>
                
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        @if($poll->is_multiple_choice)
                            Multiple choices allowed
                        @else
                            Single choice only
                        @endif
                        @if($poll->closes_at)
                            <span class="ml-2">• Closes {{ $poll->closes_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition font-medium">
                        Submit Vote
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <p class="mb-4">Please log in to vote in this poll</p>
                <a href="{{ route('login') }}" 
                   class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition">
                    Log In
                </a>
            </div>
        @endauth
    @endif
</div>
