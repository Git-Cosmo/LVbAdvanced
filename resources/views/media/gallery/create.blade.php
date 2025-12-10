@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-2">
            Upload Gaming Content
        </h1>
        <p class="dark:text-dark-text-secondary text-light-text-secondary">
            Share your custom maps, mods, skins, and resources with the FPSociety community
        </p>
    </div>

    <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        @csrf

        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                Title <span class="text-accent-red">*</span>
            </label>
            <input type="text" 
                   name="title" 
                   id="title" 
                   value="{{ old('title') }}"
                   class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                   placeholder="e.g., Dust 2 Remake for CS2"
                   required>
            @error('title')
                <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                Description
            </label>
            <textarea name="description" 
                      id="description" 
                      rows="4"
                      class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                      placeholder="Describe your content...">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Game Selection -->
        <div class="mb-6">
            <label for="game" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                Game <span class="text-accent-red">*</span>
            </label>
            <select name="game" 
                    id="game"
                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                    required>
                <option value="">Select a game</option>
                @foreach($games as $game)
                    <option value="{{ $game }}" {{ old('game') == $game ? 'selected' : '' }}>
                        {{ $game }}
                    </option>
                @endforeach
            </select>
            @error('game')
                <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label for="category" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                Category <span class="text-accent-red">*</span>
            </label>
            <select name="category" 
                    id="category"
                    class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:outline-none focus:ring-2 focus:ring-accent-blue"
                    required>
                <option value="">Select a category</option>
                <option value="map" {{ old('category') == 'map' ? 'selected' : '' }}>Map</option>
                <option value="skin" {{ old('category') == 'skin' ? 'selected' : '' }}>Skin</option>
                <option value="mod" {{ old('category') == 'mod' ? 'selected' : '' }}>Mod</option>
                <option value="texture" {{ old('category') == 'texture' ? 'selected' : '' }}>Texture</option>
                <option value="sound" {{ old('category') == 'sound' ? 'selected' : '' }}>Sound</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('category')
                <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Upload -->
        <div class="mb-6">
            <label for="files" class="block text-sm font-medium dark:text-dark-text-bright text-light-text-bright mb-2">
                Files <span class="text-accent-red">*</span>
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg dark:border-dark-border-primary border-light-border-primary hover:border-accent-blue transition-colors">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 dark:text-dark-text-tertiary text-light-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <div class="flex text-sm dark:text-dark-text-secondary text-light-text-secondary">
                        <label for="files" class="relative cursor-pointer rounded-md font-medium text-accent-blue hover:text-accent-purple transition-colors">
                            <span>Upload files</span>
                            <input id="files" 
                                   name="files[]" 
                                   type="file" 
                                   class="sr-only" 
                                   multiple
                                   required>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                        PNG, JPG, GIF, ZIP, RAR up to 100MB
                    </p>
                </div>
            </div>
            @error('files')
                <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
            @enderror
            @error('files.*')
                <p class="mt-1 text-sm text-accent-red">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-4 border-t dark:border-dark-border-primary border-light-border-primary">
            <a href="{{ route('media.index') }}" class="px-6 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg font-medium hover:shadow-lg transition-all">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                Upload Content
            </button>
        </div>
    </form>
</div>

<script>
    // File upload preview (optional enhancement)
    const fileInput = document.getElementById('files');
    fileInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 0) {
            console.log(`${files.length} file(s) selected`);
        }
    });
</script>
@endsection
