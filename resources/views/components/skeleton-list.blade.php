@props(['count' => 3])

<div class="space-y-4">
    @for($i = 0; $i < $count; $i++)
        <div class="animate-pulse dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-4">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-full flex-shrink-0"></div>
                <div class="flex-1 space-y-3">
                    <div class="h-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded w-3/4"></div>
                    <div class="h-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded w-full"></div>
                    <div class="h-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded w-5/6"></div>
                    <div class="flex gap-2">
                        <div class="h-6 w-16 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded"></div>
                        <div class="h-6 w-16 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    @endfor
</div>
