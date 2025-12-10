<div class="block link-list-block">
    @if($links->count() > 0)
        <ul class="space-y-1">
            @foreach($links as $link)
                <li>
                    <a href="{{ $link['url'] }}" 
                       target="{{ $link['target'] }}"
                       class="flex items-center space-x-2 dark:text-dark-text-primary text-light-text-primary dark:hover:text-dark-text-accent hover:text-light-text-accent dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary rounded-lg px-3 py-2 transition-all group">
                        <svg class="w-4 h-4 dark:text-dark-text-tertiary text-light-text-tertiary group-hover:text-current transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                        <span class="text-sm">{{ $link['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm text-center py-4">No links available.</p>
    @endif
</div>
