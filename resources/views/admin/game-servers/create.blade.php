@extends('admin.layouts.app')

@section('title', 'Add Game Server')
@section('header', 'Add Game Server')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.game-servers.store') }}" method="POST">
        @csrf
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 dark:text-dark-text-bright">Server Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Server Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright @error('name') border-red-500 @enderror">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="game" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Game *</label>
                    <input type="text" name="game" id="game" value="{{ old('game') }}" required
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="game_short_code" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Short Code *</label>
                    <input type="text" name="game_short_code" id="game_short_code" value="{{ old('game_short_code') }}" maxlength="10" required
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                    <p class="mt-1 text-xs dark:text-dark-text-tertiary">E.g., "5M", "CS2"</p>
                </div>

                <div>
                    <label for="game_mode" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Game Mode</label>
                    <input type="text" name="game_mode" id="game_mode" value="{{ old('game_mode') }}"
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                </div>

                <div>
                    <label for="display_order" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Display Order</label>
                    <input type="number" name="display_order" id="display_order" value="{{ old('display_order', 0) }}" min="0"
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Description</label>
                <textarea name="description" id="description" rows="2"
                    class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="ip_address" class="block text-sm font-medium dark:text-dark-text-primary mb-1">IP Address</label>
                    <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}"
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                </div>

                <div>
                    <label for="port" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Port</label>
                    <input type="number" name="port" id="port" value="{{ old('port') }}" min="1" max="65535"
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Status *</label>
                    <select name="status" id="status" required class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                        <option value="coming_soon" {{ old('status') === 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                        <option value="online" {{ old('status') === 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('status') === 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="connect_url" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Connect URL</label>
                <input type="url" name="connect_url" id="connect_url" value="{{ old('connect_url') }}"
                    class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                <p class="mt-1 text-xs dark:text-dark-text-tertiary">Direct connect URL (e.g., steam://connect/...)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="max_players" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Max Players</label>
                    <input type="number" name="max_players" id="max_players" value="{{ old('max_players') }}" min="0"
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                </div>

                <div>
                    <label for="current_players" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Current Players</label>
                    <input type="number" name="current_players" id="current_players" value="{{ old('current_players', 0) }}" min="0"
                        class="w-full px-3 py-2 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary dark:text-dark-text-bright">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="icon_color_from" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Icon Gradient Start *</label>
                    <input type="color" name="icon_color_from" id="icon_color_from" value="{{ old('icon_color_from', '#8B5CF6') }}" required
                        class="w-full h-10 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary">
                </div>

                <div>
                    <label for="icon_color_to" class="block text-sm font-medium dark:text-dark-text-primary mb-1">Icon Gradient End *</label>
                    <input type="color" name="icon_color_to" id="icon_color_to" value="{{ old('icon_color_to', '#EC4899') }}" required
                        class="w-full h-10 border dark:border-dark-border-primary rounded-lg dark:bg-dark-bg-tertiary">
                </div>
            </div>

            <div class="flex items-center space-x-6 mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="ml-2 text-sm dark:text-dark-text-primary">Featured</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="ml-2 text-sm dark:text-dark-text-primary">Active</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.game-servers.index') }}" class="px-4 py-2 border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary hover:bg-gray-50 dark:hover:bg-dark-bg-tertiary">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple hover:from-accent-blue/80 hover:to-accent-purple/80 text-white rounded-lg">
                Add Server
            </button>
        </div>
    </form>
</div>
@endsection
