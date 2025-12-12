<x-admin-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Backup Management</h1>
            <form method="POST" action="{{ route('admin.backups.create') }}">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Create Backup
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-gray-400 text-sm">Total Backups</div>
                <div class="text-white text-2xl font-bold">{{ $stats['total_backups'] }}</div>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-gray-400 text-sm">Total Size</div>
                <div class="text-white text-2xl font-bold">{{ number_format($stats['total_size'] / 1024 / 1024, 2) }} MB</div>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-gray-400 text-sm">Latest Backup</div>
                <div class="text-white text-sm">{{ $stats['latest_backup'] ? $stats['latest_backup']['date']->diffForHumans() : 'None' }}</div>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="text-gray-400 text-sm">Health Status</div>
                <div class="text-xl font-bold {{ $stats['health_status'] == 'healthy' ? 'text-green-400' : 'text-red-400' }}">
                    {{ ucfirst($stats['health_status']) }}
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Disk</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($backups as $backup)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 text-white">{{ $backup['date']->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ number_format($backup['size'] / 1024 / 1024, 2) }} MB</td>
                            <td class="px-6 py-4 text-gray-300">{{ $backup['disk'] }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.backups.download', [$backup['disk'], basename($backup['path'])]) }}" class="text-blue-400 hover:text-blue-300 mr-4">Download</a>
                                <form method="POST" action="{{ route('admin.backups.destroy', [$backup['disk'], basename($backup['path'])]) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this backup?')" class="text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
