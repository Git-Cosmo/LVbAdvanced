@props([
    'count' => 0,
    'max' => 99,
    'position' => 'top-right', // top-right, top-left, bottom-right, bottom-left
    'color' => 'red', // red, blue, green, yellow, purple
    'size' => 'md' // sm, md, lg
])

@php
$positionClasses = [
    'top-right' => '-top-1 -right-1',
    'top-left' => '-top-1 -left-1',
    'bottom-right' => '-bottom-1 -right-1',
    'bottom-left' => '-bottom-1 -left-1',
];

$colorClasses = [
    'red' => 'bg-red-500',
    'blue' => 'bg-accent-blue',
    'green' => 'bg-green-500',
    'yellow' => 'bg-yellow-500',
    'purple' => 'bg-accent-purple',
];

$sizeClasses = [
    'sm' => 'text-xs min-w-[18px] h-[18px] px-1',
    'md' => 'text-xs min-w-[20px] h-[20px] px-1.5',
    'lg' => 'text-sm min-w-[24px] h-[24px] px-2',
];

$displayCount = $count > $max ? $max . '+' : $count;
@endphp

@if($count > 0)
<span class="absolute {{ $positionClasses[$position] ?? $positionClasses['top-right'] }} {{ $colorClasses[$color] ?? $colorClasses['red'] }} {{ $sizeClasses[$size] ?? $sizeClasses['md'] }} rounded-full flex items-center justify-center text-white font-bold animate-pulse">
    {{ $displayCount }}
</span>
@endif
