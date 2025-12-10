@props(['block'])

<div 
    @class([
        'block-wrapper bg-white rounded-lg shadow-md overflow-hidden',
        $block->html_class ?? '',
    ])
    @if($block->html_id)
        id="{{ $block->html_id }}"
    @endif
>
    @if($block->show_title && $block->title)
        <div class="block-header bg-gradient-to-r from-primary-500 to-primary-600 text-white px-4 py-3">
            <h2 class="text-lg font-semibold">{{ $block->title }}</h2>
        </div>
    @endif
    
    <div class="block-content p-4">
        {{ $slot }}
    </div>
</div>
