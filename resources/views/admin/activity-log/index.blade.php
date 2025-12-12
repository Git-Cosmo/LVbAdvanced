<x-admin-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-6">Activity Log</h1>

        <div class="bg-gray-800 rounded-lg p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="bg-gray-700 text-white rounded px-4 py-2">
                <select name="log_name" class="bg-gray-700 text-white rounded px-4 py-2">
                    <option value="">All Logs</option>
                    @foreach($logNames as $logName)
                        <option value="{{ $logName }}" {{ request('log_name') == $logName ? 'selected' : '' }}>{{ $logName }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-gray-700 text-white rounded px-4 py-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Filter</button>
            </form>
        </div>

        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Causer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($activities as $activity)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 text-white">{{ $activity->log_name }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $activity->description }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $activity->causer?->name ?? 'System' }}</td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $activity->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $activities->links() }}</div>
    </div>
</x-admin-layout>
