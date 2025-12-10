<div class="block stats-block">
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-primary-50 rounded-lg p-4">
            <div class="text-3xl font-bold text-primary-600">{{ $stats['total_users'] }}</div>
            <div class="text-sm text-gray-600">Total Users</div>
        </div>
        <div class="bg-primary-50 rounded-lg p-4">
            <div class="text-3xl font-bold text-primary-600">{{ $stats['total_pages'] }}</div>
            <div class="text-sm text-gray-600">Pages</div>
        </div>
        <div class="bg-primary-50 rounded-lg p-4">
            <div class="text-3xl font-bold text-primary-600">{{ $stats['total_blocks'] }}</div>
            <div class="text-sm text-gray-600">Blocks</div>
        </div>
        <div class="bg-primary-50 rounded-lg p-4">
            <div class="text-3xl font-bold text-primary-600">{{ $stats['online_users'] }}</div>
            <div class="text-sm text-gray-600">Online</div>
        </div>
    </div>
</div>
