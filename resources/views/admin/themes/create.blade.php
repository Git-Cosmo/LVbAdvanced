@extends('admin.layouts.app')

@section('header', 'Create Theme')

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.themes.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6 space-y-4">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-4">Basic Information</h3>

            <div>
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Theme Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                    placeholder="e.g., Christmas 2025">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Slug (optional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}"
                    class="w-full px-4 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                    placeholder="e.g., christmas (auto-generated if empty)">
            </div>

            <div>
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full px-4 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                </div>

                <div>
                    <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" required
                        class="w-full px-4 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium dark:text-dark-text-primary mb-2">Priority (higher = more important)</label>
                <input type="number" name="priority" value="{{ old('priority', 0) }}" min="0"
                    class="w-full px-4 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                    class="w-4 h-4 text-accent-blue border-gray-300 rounded focus:ring-accent-blue">
                <label for="is_active" class="ml-2 text-sm dark:text-dark-text-primary">Active (theme will display during date range)</label>
            </div>
        </div>

        <div class="dark:bg-dark-bg-secondary rounded-lg border dark:border-dark-border-primary p-6 space-y-4">
            <h3 class="text-lg font-semibold dark:text-dark-text-bright mb-4">Visual Effects</h3>

            <!-- Snow Effect -->
            <div class="border-b dark:border-dark-border-primary pb-4">
                <div class="flex items-center mb-2">
                    <input type="checkbox" name="enable_snow" id="enable_snow" value="1"
                        class="w-4 h-4 text-accent-blue border-gray-300 rounded focus:ring-accent-blue">
                    <label for="enable_snow" class="ml-2 text-sm font-medium dark:text-dark-text-primary">❄️ Snowfall Effect</label>
                </div>
                <div class="ml-6">
                    <label class="block text-sm dark:text-dark-text-secondary mb-1">Intensity</label>
                    <select name="snow_intensity" class="px-3 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary">
                        <option value="light">Light</option>
                        <option value="medium" selected>Medium</option>
                        <option value="heavy">Heavy</option>
                    </select>
                </div>
            </div>

            <!-- Lights Effect -->
            <div class="border-b dark:border-dark-border-primary pb-4">
                <div class="flex items-center mb-2">
                    <input type="checkbox" name="enable_lights" id="enable_lights" value="1"
                        class="w-4 h-4 text-accent-blue border-gray-300 rounded focus:ring-accent-blue">
                    <label for="enable_lights" class="ml-2 text-sm font-medium dark:text-dark-text-primary">💡 Christmas Lights</label>
                </div>
                <div class="ml-6">
                    <label class="block text-sm dark:text-dark-text-secondary mb-1">Color Scheme</label>
                    <select name="lights_color" class="px-3 py-2 dark:bg-dark-bg-tertiary border dark:border-dark-border-primary rounded-lg dark:text-dark-text-primary">
                        <option value="multicolor" selected>Multicolor</option>
                        <option value="warm">Warm White</option>
                        <option value="cool">Cool White</option>
                    </select>
                </div>
            </div>

            <!-- Confetti Effect -->
            <div class="border-b dark:border-dark-border-primary pb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="enable_confetti" id="enable_confetti" value="1"
                        class="w-4 h-4 text-accent-blue border-gray-300 rounded focus:ring-accent-blue">
                    <label for="enable_confetti" class="ml-2 text-sm font-medium dark:text-dark-text-primary">🎉 Confetti Effect</label>
                </div>
                <p class="ml-6 text-xs dark:text-dark-text-tertiary mt-1">Perfect for celebrations and special events</p>
            </div>

            <!-- Fireworks Effect -->
            <div>
                <div class="flex items-center">
                    <input type="checkbox" name="enable_fireworks" id="enable_fireworks" value="1"
                        class="w-4 h-4 text-accent-blue border-gray-300 rounded focus:ring-accent-blue">
                    <label for="enable_fireworks" class="ml-2 text-sm font-medium dark:text-dark-text-primary">🎆 Fireworks Effect</label>
                </div>
                <p class="ml-6 text-xs dark:text-dark-text-tertiary mt-1">Ideal for New Year and major celebrations</p>
            </div>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg hover:opacity-90 transition-opacity">
                Create Theme
            </button>
            <a href="{{ route('admin.themes.index') }}" class="px-6 py-2 dark:bg-dark-bg-tertiary dark:text-dark-text-primary rounded-lg hover:dark:bg-dark-bg-elevated transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
