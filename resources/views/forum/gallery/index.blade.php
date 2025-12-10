@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $user->name }}'s Gallery
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ $images->total() }} images
                </p>
            </div>
            
            @auth
                @if(auth()->id() === $user->id)
                    <button onclick="document.getElementById('uploadModal').classList.remove('hidden')"
                            class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all">
                        📤 Upload Image
                    </button>
                @endif
            @endauth
        </div>
    </div>

    @if($images->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🖼️</div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Images Yet</h3>
            <p class="text-gray-600 dark:text-gray-400">
                @auth
                    @if(auth()->id() === $user->id)
                        Start building your gallery by uploading your first image.
                    @else
                        This user hasn't uploaded any images yet.
                    @endif
                @else
                    This user hasn't uploaded any images yet.
                @endauth
            </p>
        </div>
    @else
        <!-- Gallery Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach($images as $image)
                <a href="{{ route('forum.gallery.show', $image) }}" 
                   class="group relative aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800">
                    <img src="{{ Storage::url('gallery/' . $image->filename) }}" 
                         alt="{{ $image->original_filename }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-end p-2">
                        <div class="text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="text-xs">{{ $image->created_at->diffForHumans() }}</div>
                            <div class="text-xs">👁️ {{ $image->downloads_count }} views</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $images->links() }}
        </div>
    @endif
</div>

<!-- Upload Modal -->
@auth
    @if(auth()->id() === $user->id)
        <div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Upload Image</h3>
                    <button onclick="document.getElementById('uploadModal').classList.add('hidden')"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        ✕
                    </button>
                </div>

                <form action="{{ route('forum.gallery.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Select Image
                            </label>
                            <input type="file" name="image" accept="image/*" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max size: 5MB. Formats: JPG, PNG, GIF, WebP</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Title (Optional)
                            </label>
                            <input type="text" name="title" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description (Optional)
                            </label>
                            <textarea name="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all">
                                Upload
                            </button>
                            <button type="button"
                                    onclick="document.getElementById('uploadModal').classList.add('hidden')"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endauth
@endsection
