<div class="block stats-block">
    <div class="grid grid-cols-2 gap-3">
        <div class="dark:bg-gradient-to-br from-accent-blue/10 to-accent-purple/10 bg-gradient-to-br from-light-text-accent/10 to-accent-purple/10 dark:border dark:border-accent-blue/20 border border-light-text-accent/20 rounded-xl p-4 hover:scale-105 transition-transform">
            <div class="text-3xl font-bold dark:text-accent-blue text-light-text-accent">{{ $stats['total_users'] }}</div>
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary mt-1">Total Users</div>
        </div>
        <div class="dark:bg-gradient-to-br from-accent-green/10 to-accent-blue/10 bg-gradient-to-br from-accent-green/10 to-light-text-accent/10 dark:border dark:border-accent-green/20 border border-accent-green/20 rounded-xl p-4 hover:scale-105 transition-transform">
            <div class="text-3xl font-bold dark:text-accent-green text-accent-green">{{ $stats['total_pages'] }}</div>
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary mt-1">Pages</div>
        </div>
        <div class="dark:bg-gradient-to-br from-accent-purple/10 to-accent-blue/10 bg-gradient-to-br from-accent-purple/10 to-light-text-accent/10 dark:border dark:border-accent-purple/20 border border-accent-purple/20 rounded-xl p-4 hover:scale-105 transition-transform">
            <div class="text-3xl font-bold dark:text-accent-purple text-accent-purple">{{ $stats['total_blocks'] }}</div>
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary mt-1">Blocks</div>
        </div>
        <div class="dark:bg-gradient-to-br from-accent-orange/10 to-accent-yellow/10 bg-gradient-to-br from-accent-orange/10 to-accent-yellow/10 dark:border dark:border-accent-orange/20 border border-accent-orange/20 rounded-xl p-4 hover:scale-105 transition-transform">
            <div class="text-3xl font-bold dark:text-accent-orange text-accent-orange">{{ $stats['online_users'] }}</div>
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary mt-1">Online</div>
        </div>
    </div>
</div>
