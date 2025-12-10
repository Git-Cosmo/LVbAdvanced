<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright flex items-center">
            <span class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
            Who's Online
        </h3>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="text-center p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
            <div class="text-2xl font-bold dark:text-dark-text-accent text-light-text-accent">
                {{ $total_online }}
            </div>
            <div class="text-xs dark:text-dark-text-secondary text-light-text-secondary">
                Members
            </div>
        </div>
        <div class="text-center p-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
            <div class="text-2xl font-bold dark:text-dark-text-accent text-light-text-accent">
                {{ $guest_count }}
            </div>
            <div class="text-xs dark:text-dark-text-secondary text-light-text-secondary">
                Guests
            </div>
        </div>
    </div>

    <!-- Online Users List -->
    @if($online_users->isNotEmpty())
    <div class="space-y-2">
        @foreach($online_users->take($max_display) as $user)
        <a href="{{ route('profile.show', $user) }}" 
           class="flex items-center space-x-3 p-2 rounded-lg dark:hover:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition-colors group">
            @if($show_avatars)
            <div class="relative">
                @if($user->profile?->avatar)
                <img src="{{ Storage::url($user->profile->avatar) }}" 
                     alt="{{ $user->name }}" 
                     class="w-8 h-8 rounded-full">
                @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>
                @endif
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 dark:border-dark-bg-secondary border-light-bg-secondary rounded-full"></span>
            </div>
            @endif
            
            <div class="flex-1 min-w-0">
                <div class="font-medium dark:text-dark-text-bright text-light-text-bright group-hover:dark:text-dark-text-accent group-hover:text-light-text-accent transition-colors truncate">
                    {{ $user->name }}
                </div>
                @if($user->profile)
                <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                    Level {{ $user->profile->level }}
                </div>
                @endif
            </div>
            
            <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                {{ $user->last_active_at ? $user->last_active_at->diffForHumans(null, true) : 'now' }}
            </div>
        </a>
        @endforeach
        
        @if($total_online > $max_display)
        <div class="text-center pt-2">
            <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                +{{ $total_online - $max_display }} more online
            </span>
        </div>
        @endif
    </div>
    @else
    <div class="text-center py-4">
        <p class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
            No users currently online
        </p>
    </div>
    @endif
</div>
