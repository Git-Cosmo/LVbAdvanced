<div class="block advertisement-block">
    @if($adType === 'code' && $adCode)
        <!-- Third-party Ad Code -->
        <!-- Note: Ad code is rendered unescaped by design to support third-party ad scripts. 
             Only administrators should have permission to create/edit advertisement blocks. -->
        <div class="ad-code-wrapper">
            {!! $adCode !!}
        </div>
    @elseif($adType === 'image' && $imageUrl)
        <!-- Image Banner Ad -->
        <div class="group">
            @if($linkUrl)
                <a href="{{ $linkUrl }}" 
                   target="{{ $target }}"
                   rel="noopener noreferrer"
                   class="block overflow-hidden rounded-lg transition-transform hover:scale-[1.02]">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $title ?: 'Advertisement' }}" 
                         class="w-full h-auto object-cover">
                </a>
            @else
                <div class="overflow-hidden rounded-lg">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $title ?: 'Advertisement' }}" 
                         class="w-full h-auto object-cover">
                </div>
            @endif
        </div>
    @elseif($adType === 'text')
        <!-- Text Ad -->
        <div class="dark:bg-gradient-to-br from-accent-blue/10 to-accent-purple/10 bg-gradient-to-br from-light-text-accent/10 to-accent-purple/10 dark:border dark:border-accent-blue/20 border border-light-text-accent/20 rounded-xl p-5 hover:shadow-lg transition-shadow">
            @if($title)
                <h3 class="text-base font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
                    {{ $title }}
                </h3>
            @endif
            
            @if($description)
                <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm leading-relaxed mb-4">
                    {{ $description }}
                </p>
            @endif
            
            @if($linkUrl)
                <a href="{{ $linkUrl }}" 
                   target="{{ $target }}"
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-4 py-2 dark:bg-accent-blue bg-light-text-accent text-white rounded-lg text-sm font-medium hover:opacity-90 transition-opacity">
                    {{ $ctaText }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            @endif
        </div>
    @else
        <div class="text-center py-8 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
            <svg class="w-12 h-12 mx-auto dark:text-dark-text-tertiary text-light-text-tertiary mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm">
                Configure advertisement settings to display content
            </p>
        </div>
    @endif
</div>
