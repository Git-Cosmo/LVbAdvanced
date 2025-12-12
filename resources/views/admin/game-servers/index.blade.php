@extends('admin.layouts.app')

@section('title', 'Game Server Management')
@section('header', 'Game Server Management')

@section('content')
<div class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Total Servers</div>
            <div class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright">{{ $stats['total'] }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Active</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Online</div>
            <div class="text-2xl font-bold text-emerald-600">{{ $stats['online'] }}</div>
        </div>
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg p-4 border dark:border-dark-border-primary border-light-border-primary">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">Featured</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['featured'] }}</div>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <p class="dark:text-dark-text-secondary text-light-text-secondary">Manage game servers displayed on the portal</p>
        <a href="{{ route('admin.game-servers.create') }}" class="bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Server
        </a>
    </div>
</div>

<div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y dark:divide-dark-border-primary divide-light-border-primary">
        <thead class="bg-gray-50 dark:bg-dark-bg-tertiary">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Server</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Address</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Players</th>
                <th class="px-6 py-3 text-left text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Order</th>
                <th class="px-6 py-3 text-right text-xs font-medium dark:text-dark-text-secondary text-light-text-secondary uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="dark:bg-dark-bg-secondary bg-light-bg-secondary divide-y dark:divide-dark-border-primary divide-light-border-primary">
            @forelse ($servers as $server)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded flex items-center justify-center flex-shrink-0" style="background: linear-gradient(to bottom right, {{ $server->icon_color_from }}, {{ $server->icon_color_to }});">
                                <span class="text-white font-bold text-xs">{{ $server->game_short_code }}</span>
                            </div>
                            <div>
                                <div class="text-sm font-medium dark:text-dark-text-bright text-light-text-bright">{{ $server->name }}</div>
                                <div class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">{{ $server->game }} • {{ $server->game_mode ?? 'N/A' }}</div>
                                @if ($server->is_featured)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 mt-1">
                                        Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        @if ($server->connect_address)
                            <code class="text-xs bg-gray-100 dark:bg-dark-bg-tertiary px-2 py-1 rounded">{{ $server->connect_address }}</code>
                        @else
                            <span class="text-gray-500">Not set</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($server->status === 'online') bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-400
                            @elseif($server->status === 'offline') bg-rose-100 dark:bg-rose-900/30 text-rose-800 dark:text-rose-400
                            @elseif($server->status === 'maintenance') bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-400
                            @else bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                            @endif">
                            {{ $server->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        @if($server->max_players)
                            {{ $server->current_players }} / {{ $server->max_players }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        {{ $server->display_order }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <form action="{{ route('admin.game-servers.toggle-active', $server) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-sm px-2 py-1 rounded {{ $server->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-400' }}">
                                    {{ $server->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.game-servers.edit', $server) }}" class="text-accent-blue dark:text-accent-blue hover:text-accent-purple">
                                Edit
                            </a>
                            <form action="{{ route('admin.game-servers.destroy', $server) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this server?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary">No game servers yet. Add your first server!</p>
                        <a href="{{ route('admin.game-servers.create') }}" class="mt-4 inline-block bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white px-4 py-2 rounded-lg">
                            Add First Server
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($servers->hasPages())
        <div class="px-6 py-4 border-t dark:border-dark-border-primary border-light-border-primary">
            {{ $servers->links() }}
        </div>
    @endif
</div>
@endsection
