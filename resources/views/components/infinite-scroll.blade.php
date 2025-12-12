@props(['loadMoreUrl' => null, 'threshold' => '200px'])

<div x-data="infiniteScroll()" x-init="init()">
    <div x-ref="content">
        {{ $slot }}
    </div>
    
    <!-- Loading indicator -->
    <div x-show="loading" class="flex justify-center py-8">
        <div class="flex items-center space-x-3">
            <svg class="animate-spin h-8 w-8 dark:text-dark-text-accent text-light-text-accent" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="dark:text-dark-text-secondary text-light-text-secondary">Loading more...</span>
        </div>
    </div>
    
    <!-- End of content message -->
    <div x-show="!hasMore && !loading" class="text-center py-8">
        <p class="dark:text-dark-text-tertiary text-light-text-tertiary">
            No more items to load
        </p>
    </div>
    
    <!-- Intersection observer target -->
    <div x-ref="sentinel" class="h-1"></div>
</div>

<script>
function infiniteScroll() {
    return {
        loading: false,
        hasMore: true,
        nextPageUrl: @json($loadMoreUrl),
        observer: null,
        
        init() {
            if (!this.nextPageUrl) {
                this.hasMore = false;
                return;
            }
            
            // Create intersection observer
            this.observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting && !this.loading && this.hasMore) {
                            this.loadMore();
                        }
                    });
                },
                {
                    rootMargin: '{{ $threshold }}',
                    threshold: 0.1
                }
            );
            
            // Start observing the sentinel element
            this.observer.observe(this.$refs.sentinel);
        },
        
        async loadMore() {
            if (!this.nextPageUrl || this.loading || !this.hasMore) {
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(this.nextPageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                if (!response.ok) {
                    throw new Error('Failed to load more items');
                }
                
                const data = await response.json();
                
                // Append new items to content
                if (data.html) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;
                    this.$refs.content.appendChild(tempDiv.firstChild);
                }
                
                // Update next page URL
                this.nextPageUrl = data.next_page_url;
                
                // Check if there are more pages
                if (!data.next_page_url) {
                    this.hasMore = false;
                    if (this.observer) {
                        this.observer.disconnect();
                    }
                }
            } catch (error) {
                console.error('Error loading more items:', error);
                this.hasMore = false;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
