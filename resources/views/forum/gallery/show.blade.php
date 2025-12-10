@extends('portal.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Navigation -->
    <div class="mb-4">
        <a href="{{ route('forum.gallery.index', $image->user) }}" 
           class="text-purple-600 dark:text-purple-400 hover:underline">
            ← Back to Gallery
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <!-- Image -->
        <div class="bg-black flex items-center justify-center" style="min-height: 500px;">
            <img src="{{ Storage::url('gallery/' . $image->filename) }}" 
                 alt="{{ $image->original_filename }}"
                 class="max-w-full max-h-screen object-contain">
        </div>

        <!-- Info -->
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ $image->original_filename }}
                    </h1>
                    <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <span>Uploaded by <a href="{{ route('profile.show', $image->user) }}" class="text-purple-600 dark:text-purple-400 hover:underline">{{ $image->user->name }}</a></span>
                        <span>{{ $image->created_at->format('M d, Y') }}</span>
                        <span>👁️ {{ $image->downloads_count }} views</span>
                        <span>{{ $image->human_size }}</span>
                    </div>
                </div>

                @auth
                    @if(auth()->id() === $image->user_id)
                        <form action="{{ route('forum.gallery.destroy', $image) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this image?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                🗑️ Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            <!-- Actions -->
            <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('forum.attachment.download', $image) }}" 
                   class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition-all">
                    📥 Download
                </a>
                <button onclick="navigator.clipboard.writeText('{{ Storage::url('gallery/' . $image->filename) }}')"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    🔗 Copy Link
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
