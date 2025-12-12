@props(['event'])

<div x-data="eventRsvp()" class="dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-xl p-4">
    <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-3">
        Attending?
    </h3>
    
    @auth
        @php
            $userRsvpStatus = $event->getUserRsvpStatus(auth()->id());
        @endphp
        
        <form action="{{ route('events.rsvp', $event) }}" method="POST" class="space-y-3">
            @csrf
            
            <!-- RSVP Status Options -->
            <div class="space-y-2">
                <label class="flex items-center p-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                    <input type="radio" 
                           name="status" 
                           value="going"
                           {{ $userRsvpStatus === 'going' ? 'checked' : '' }}
                           class="w-4 h-4 text-accent-blue focus:ring-2 focus:ring-accent-blue">
                    <div class="ml-3 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium dark:text-dark-text-bright text-light-text-bright">
                            Going ({{ $event->goingCount() }})
                        </span>
                    </div>
                </label>

                <label class="flex items-center p-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                    <input type="radio" 
                           name="status" 
                           value="interested"
                           {{ $userRsvpStatus === 'interested' ? 'checked' : '' }}
                           class="w-4 h-4 text-accent-blue focus:ring-2 focus:ring-accent-blue">
                    <div class="ml-3 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span class="font-medium dark:text-dark-text-bright text-light-text-bright">
                            Interested ({{ $event->interestedCount() }})
                        </span>
                    </div>
                </label>

                <label class="flex items-center p-2 dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                    <input type="radio" 
                           name="status" 
                           value="not_going"
                           {{ $userRsvpStatus === 'not_going' ? 'checked' : '' }}
                           class="w-4 h-4 text-accent-blue focus:ring-2 focus:ring-accent-blue">
                    <div class="ml-3 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium dark:text-dark-text-bright text-light-text-bright">
                            Can't Go
                        </span>
                    </div>
                </label>
            </div>

            <!-- Optional Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">
                    Add a note (optional)
                </label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="2" 
                    maxlength="500"
                    placeholder="e.g., Bringing friends, need a ride, etc."
                    class="w-full px-3 py-2 text-sm rounded-lg dark:bg-dark-bg-secondary bg-light-bg-secondary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Update RSVP
                </button>
                
                @if($userRsvpStatus)
                <form action="{{ route('events.rsvp.cancel', $event) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 dark:bg-dark-bg-secondary bg-light-bg-secondary dark:text-dark-text-primary text-light-text-primary rounded-lg hover:opacity-80 transition-opacity">
                        Cancel
                    </button>
                </form>
                @endif
            </div>
        </form>
    @else
        <!-- Not logged in message -->
        <div class="text-center py-6">
            <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                Sign in to RSVP for this event
            </p>
            <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                Sign In
            </a>
        </div>
    @endauth
    
    <!-- Stats Summary -->
    <div class="mt-4 pt-4 border-t dark:border-dark-border-primary border-light-border-primary">
        <div class="grid grid-cols-2 gap-4 text-center">
            <div>
                <div class="text-2xl font-bold dark:text-dark-text-accent text-light-text-accent">
                    {{ $event->goingCount() }}
                </div>
                <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Going</div>
            </div>
            <div>
                <div class="text-2xl font-bold dark:text-dark-text-accent text-light-text-accent">
                    {{ $event->interestedCount() }}
                </div>
                <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Interested</div>
            </div>
        </div>
    </div>
</div>

<script>
function eventRsvp() {
    return {
        // Additional JavaScript functionality can be added here if needed
    }
}
</script>
