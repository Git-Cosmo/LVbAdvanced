@props(['height' => 'h-48'])

<div class="animate-pulse dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 {{ $height }}">
    <div class="space-y-4">
        <div class="h-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded w-3/4"></div>
        <div class="h-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded"></div>
        <div class="h-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded w-5/6"></div>
        <div class="h-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded w-2/3"></div>
    </div>
</div>
