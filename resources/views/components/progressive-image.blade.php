@props([
    'src' => '',
    'alt' => '',
    'placeholderColor' => '#1e293b',
    'aspectRatio' => '16/9',
    'class' => '',
    'lazy' => true
])

<div 
    x-data="progressiveImage()" 
    x-init="init()"
    class="relative overflow-hidden {{ $class }}"
    style="aspect-ratio: {{ $aspectRatio }}; background-color: {{ $placeholderColor }};"
>
    <!-- Placeholder/Blur layer -->
    <div 
        x-show="!loaded" 
        class="absolute inset-0 flex items-center justify-center"
    >
        <div class="animate-pulse w-full h-full bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700"></div>
        <svg class="absolute w-12 h-12 dark:text-dark-text-tertiary text-light-text-tertiary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
    
    <!-- Actual image -->
    <img 
        x-ref="image"
        src="{{ $src }}"
        alt="{{ $alt }}"
        @load="handleLoad()"
        @error="handleError()"
        {{ $lazy ? 'loading=lazy' : '' }}
        x-show="loaded"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="absolute inset-0 w-full h-full object-cover"
    />
    
    <!-- Error state -->
    <div 
        x-show="error" 
        class="absolute inset-0 flex flex-col items-center justify-center dark:bg-dark-bg-tertiary bg-light-bg-tertiary"
    >
        <svg class="w-12 h-12 dark:text-dark-text-tertiary text-light-text-tertiary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <span class="text-sm dark:text-dark-text-tertiary text-light-text-tertiary">Image failed to load</span>
    </div>
</div>

<script>
function progressiveImage() {
    return {
        loaded: false,
        error: false,
        
        init() {
            // Check if image is already loaded (from cache)
            if (this.$refs.image.complete) {
                this.loaded = true;
            }
        },
        
        handleLoad() {
            this.loaded = true;
            this.error = false;
        },
        
        handleError() {
            this.error = true;
            this.loaded = false;
        }
    }
}
</script>
