@props(['block'])

<div 
    @class([
        'block-wrapper block-hover dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl dark:border dark:border-dark-border-primary border border-light-border-primary overflow-hidden dark:shadow-dark-md shadow-md',
        $block->html_class ?? '',
    ])
    @if($block->html_id)
        id="{{ $block->html_id }}"
    @endif
>
    @if($block->show_title && $block->title)
        <div class="block-header dark:bg-dark-bg-elevated bg-light-bg-elevated dark:border-b dark:border-dark-border-primary border-b border-light-border-primary px-5 py-4">
            <h2 class="text-base font-bold dark:text-dark-text-bright text-light-text-bright flex items-center space-x-2">
                <span class="w-1 h-5 bg-gradient-to-b from-accent-blue to-accent-purple rounded-full"></span>
                <span>{{ $block->title }}</span>
            </h2>
        </div>
    @endif
    
    <div class="block-content p-5">
        {{ $slot }}
    </div>
</div>
