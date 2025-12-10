<div class="block latest-news-block">
    @if($news->count() > 0)
        <div class="space-y-4">
            @foreach($news as $item)
                <article class="dark:border-b dark:border-dark-border-secondary border-b border-light-border-secondary pb-4 last:border-0 group">
                    <h3 class="text-base font-semibold dark:text-dark-text-bright text-light-text-bright dark:group-hover:text-dark-text-accent group-hover:text-light-text-accent transition-colors">
                        <a href="#" class="link-underline">{{ $item['title'] }}</a>
                    </h3>
                    <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mt-2 leading-relaxed">{{ $item['excerpt'] }}</p>
                    <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-3 flex items-center gap-4">
                        @if($showDate)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $item['date']->format('M d, Y') }}
                            </span>
                        @endif
                        @if($showAuthor)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $item['author'] }}
                            </span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm text-center py-4">No news available.</p>
    @endif
</div>
