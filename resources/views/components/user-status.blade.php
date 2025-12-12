@props(['user', 'size' => 'sm'])

@php
$sizeClasses = [
    'xs' => 'w-2 h-2',
    'sm' => 'w-3 h-3',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5'
];

$statusColors = [
    'online' => 'bg-green-500',
    'away' => 'bg-yellow-500',
    'busy' => 'bg-red-500',
    'offline' => 'bg-gray-500'
];

$status = $user->profile?->status ?? 'offline';
$statusMessage = $user->profile?->status_message;

// Auto-detect status based on last activity
if ($user->profile?->last_activity_at) {
    $minutesSinceActivity = now()->diffInMinutes($user->profile->last_activity_at);
    if ($minutesSinceActivity > 15) {
        $status = 'offline';
    } elseif ($minutesSinceActivity > 5 && $status === 'online') {
        $status = 'away';
    }
}
@endphp

<div class="relative inline-flex items-center group">
    <div class="{{ $sizeClasses[$size] ?? $sizeClasses['sm'] }} {{ $statusColors[$status] }} rounded-full border-2 dark:border-dark-bg-secondary border-light-bg-secondary"></div>
    
    @if($statusMessage)
    <!-- Status message tooltip -->
    <div class="absolute bottom-full left-0 mb-2 hidden group-hover:block z-10 w-max max-w-xs">
        <div class="dark:bg-dark-bg-elevated bg-light-bg-elevated px-3 py-2 rounded-lg shadow-xl text-xs dark:text-dark-text-primary text-light-text-primary">
            <div class="font-semibold mb-1">{{ ucfirst($status) }}</div>
            <div class="dark:text-dark-text-secondary text-light-text-secondary">{{ $statusMessage }}</div>
        </div>
    </div>
    @endif
</div>
