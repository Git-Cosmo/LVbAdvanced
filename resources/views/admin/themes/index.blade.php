@extends('admin.layouts.app')

@section('header', 'Theme Settings')

@section('content')
<div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold dark:text-dark-text-bright">Seasonal Themes</h2>
            <p class="dark:text-dark-text-secondary mt-1">Manage visual effects for special occasions</p>
        </div>
        <a href="{{ route('admin.themes.create') }}" class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity">
            Create Theme
        </a>
    </div>

    <!-- Active Theme Notice -->
    @if($activeTheme)
        <div class="bg-green-500/10 border border-green-500/50 rounded-lg p-4">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <div>
                    <p class="font-semibold text-green-600 dark:text-green-400">Currently Active Theme</p>
                    <p class="dark:text-dark-text-secondary">{{ $activeTheme->name }} ({{ $activeTheme->start_date->format('M d') }} - {{ $activeTheme->end_date->format('M d, Y') }})</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Themes List -->
    <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary">
        <table class="w-full">
            <thead class="border-b dark:border-dark-border-primary">
                <tr>
                    <th class="text-left px-6 py-3 dark:text-dark-text-secondary text-sm font-semibold">Theme</th>
                    <th class="text-left px-6 py-3 dark:text-dark-text-secondary text-sm font-semibold">Date Range</th>
                    <th class="text-left px-6 py-3 dark:text-dark-text-secondary text-sm font-semibold">Effects</th>
                    <th class="text-left px-6 py-3 dark:text-dark-text-secondary text-sm font-semibold">Status</th>
                    <th class="text-right px-6 py-3 dark:text-dark-text-secondary text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y dark:divide-dark-border-primary">
                @forelse($themes as $theme)
                    <tr>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold dark:text-dark-text-bright">{{ $theme->name }}</p>
                                <p class="text-sm dark:text-dark-text-tertiary">{{ $theme->slug }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 dark:text-dark-text-secondary">
                            {{ $theme->start_date->format('M d, Y') }} - {{ $theme->end_date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if($theme->effects['snow']['enabled'] ?? false)
                                    <span class="px-2 py-1 text-xs bg-blue-500/20 text-blue-400 rounded">❄️ Snow</span>
                                @endif
                                @if($theme->effects['lights']['enabled'] ?? false)
                                    <span class="px-2 py-1 text-xs bg-yellow-500/20 text-yellow-400 rounded">💡 Lights</span>
                                @endif
                                @if($theme->effects['confetti']['enabled'] ?? false)
                                    <span class="px-2 py-1 text-xs bg-purple-500/20 text-purple-400 rounded">🎉 Confetti</span>
                                @endif
                                @if($theme->effects['fireworks']['enabled'] ?? false)
                                    <span class="px-2 py-1 text-xs bg-red-500/20 text-red-400 rounded">🎆 Fireworks</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($theme->is_active && $theme->isCurrentlyValid())
                                <span class="px-2 py-1 text-xs bg-green-500/20 text-green-400 rounded-full">Active</span>
                            @elseif($theme->is_active)
                                <span class="px-2 py-1 text-xs bg-yellow-500/20 text-yellow-400 rounded-full">Scheduled</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-gray-500/20 text-gray-400 rounded-full">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <form action="{{ route('admin.themes.toggle', $theme) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm dark:text-dark-text-secondary hover:dark:text-dark-text-primary">
                                    {{ $theme->is_active ? 'Disable' : 'Enable' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.themes.edit', $theme) }}" class="text-sm text-accent-blue hover:text-accent-blue-bright">Edit</a>
                            <form action="{{ route('admin.themes.destroy', $theme) }}" method="POST" class="inline" onsubmit="return confirm('Delete this theme?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 dark:text-dark-text-tertiary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                                <p class="dark:text-dark-text-secondary text-lg mb-2">No themes created yet</p>
                                <a href="{{ route('admin.themes.create') }}" class="text-accent-blue hover:text-accent-blue-bright">Create your first theme</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($themes->hasPages())
        <div class="mt-4">
            {{ $themes->links() }}
        </div>
    @endif
</div>
@endsection
