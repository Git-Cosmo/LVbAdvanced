<div class="block recent-activity-block">
    @if($activities->count() > 0)
        <div class="space-y-3">
            @foreach($activities as $activity)
                <div class="flex items-start gap-3 dark:border-b dark:border-dark-border-secondary border-b border-light-border-secondary pb-3 last:border-0 group">
                    <!-- Icon based on event type -->
                    <div class="flex-shrink-0 mt-1">
                        @if($activity['event'] === 'created')
                            <div class="w-8 h-8 rounded-lg dark:bg-accent-green/10 bg-accent-green/10 flex items-center justify-center">
                                <svg class="w-4 h-4 dark:text-accent-green text-accent-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        @elseif($activity['event'] === 'updated')
                            <div class="w-8 h-8 rounded-lg dark:bg-accent-blue/10 bg-accent-blue/10 flex items-center justify-center">
                                <svg class="w-4 h-4 dark:text-accent-blue text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                        @elseif($activity['event'] === 'deleted')
                            <div class="w-8 h-8 rounded-lg dark:bg-red-500/10 bg-red-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 dark:text-red-400 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-8 h-8 rounded-lg dark:bg-accent-purple/10 bg-accent-purple/10 flex items-center justify-center">
                                <svg class="w-4 h-4 dark:text-accent-purple text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Activity Details -->
                    <div class="flex-1 min-w-0">
                        <div class="text-sm dark:text-dark-text-primary text-light-text-primary">
                            <span class="font-medium">{{ ucfirst($activity['event']) }}</span>
                            @if($activity['subject_type'])
                                <span class="dark:text-dark-text-secondary text-light-text-secondary">{{ $activity['subject_type'] }}</span>
                            @endif
                            @if($activity['description'])
                                <span class="dark:text-dark-text-secondary text-light-text-secondary">- {{ $activity['description'] }}</span>
                            @endif
                        </div>
                        
                        <!-- Meta Info -->
                        <div class="flex items-center gap-3 mt-1 text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            @if($showCauser)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $activity['causer_name'] }}
                                </span>
                            @endif
                            
                            @if($showTime)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $activity['created_at']->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-sm text-center py-4">No recent activity.</p>
    @endif
</div>
