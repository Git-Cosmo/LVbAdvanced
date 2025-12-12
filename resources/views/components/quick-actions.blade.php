@props(['actions' => []])

<div class="fixed bottom-6 right-6 z-40" x-data="quickActions()">
    <!-- Main Action Button (FAB) -->
    <button 
        @click="toggle()"
        class="w-14 h-14 rounded-full bg-gradient-to-r from-accent-blue to-accent-purple text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all flex items-center justify-center group"
    >
        <svg 
            x-show="!open" 
            class="w-6 h-6" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        <svg 
            x-show="open" 
            class="w-6 h-6" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    
    <!-- Action Menu -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        @click.away="open = false"
        class="absolute bottom-20 right-0 space-y-3"
    >
        @auth
            <!-- Create Thread -->
            <a href="{{ route('forum.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-lg hover:shadow-xl transition-all group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-blue to-accent-purple flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
                <span class="font-medium dark:text-dark-text-bright text-light-text-bright whitespace-nowrap">New Thread</span>
            </a>
            
            <!-- Upload Content -->
            <a href="{{ route('downloads.create') }}" 
               class="flex items-center space-x-3 px-4 py-3 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-lg hover:shadow-xl transition-all group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-purple to-accent-pink flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <span class="font-medium dark:text-dark-text-bright text-light-text-bright whitespace-nowrap">Upload</span>
            </a>
            
            <!-- Messages -->
            <a href="{{ route('forum.messaging.inbox') }}" 
               class="flex items-center space-x-3 px-4 py-3 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-lg hover:shadow-xl transition-all group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-green to-accent-teal flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-medium dark:text-dark-text-bright text-light-text-bright whitespace-nowrap">Messages</span>
            </a>
            
            <!-- Scroll to Top -->
            <button 
                @click="scrollToTop()"
                class="flex items-center space-x-3 px-4 py-3 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-lg hover:shadow-xl transition-all group w-full">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-orange to-accent-yellow flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                </div>
                <span class="font-medium dark:text-dark-text-bright text-light-text-bright whitespace-nowrap">Scroll Up</span>
            </button>
        @else
            <!-- Sign In -->
            <a href="{{ route('login') }}" 
               class="flex items-center space-x-3 px-4 py-3 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-lg hover:shadow-xl transition-all group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-blue to-accent-purple flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <span class="font-medium dark:text-dark-text-bright text-light-text-bright whitespace-nowrap">Sign In</span>
            </a>
            
            <!-- Register -->
            <a href="{{ route('register') }}" 
               class="flex items-center space-x-3 px-4 py-3 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-lg hover:shadow-xl transition-all group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-purple to-accent-pink flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <span class="font-medium dark:text-dark-text-bright text-light-text-bright whitespace-nowrap">Register</span>
            </a>
        @endauth
    </div>
</div>

<script>
function quickActions() {
    return {
        open: false,
        
        toggle() {
            this.open = !this.open;
        },
        
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            this.open = false;
        }
    }
}
</script>
