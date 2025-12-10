<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright">
            Latest Forum Threads
        </h3>
        <a href="{{ route('forum.index') }}" 
           class="text-sm dark:text-dark-text-accent text-light-text-accent dark:hover:text-dark-text-bright hover:text-light-text-bright transition-colors">
            View All →
        </a>
    </div>

    @if($threads->isNotEmpty())
    <div class="space-y-3">
        @foreach($threads as $thread)
        <a href="{{ route('forum.thread.show', $thread->slug) }}" 
           class="block p-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors group">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h4 class="font-semibold dark:text-dark-text-bright text-light-text-bright group-hover:dark:text-dark-text-accent group-hover:text-light-text-accent transition-colors">
                        {{ Str::limit($thread->title, 50) }}
                    </h4>
                    <div class="mt-2 flex items-center space-x-3 text-xs dark:text-dark-text-secondary text-light-text-secondary">
                        @if($settings['show_forum'] ?? true)
                        <span class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            {{ $thread->forum->name }}
                        </span>
                        @endif
                        
                        @if($settings['show_author'] ?? true)
                        <span class="flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $thread->user->name }}
                        </span>
                        @endif
                        
                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                
                <div class="ml-4 text-right">
                    <div class="text-sm font-semibold dark:text-dark-text-accent text-light-text-accent">
                        {{ $thread->posts_count }}
                    </div>
                    <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                        replies
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center py-8">
        <svg class="w-12 h-12 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm">
            No threads yet
        </p>
    </div>
    @endif
</div>
