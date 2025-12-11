@extends('admin.layouts.app')

@section('title', 'Move Thread')
@section('header', 'Move Thread')

@section('content')
<div class="max-w-2xl">
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        Moving thread: <strong>{{ $thread->title }}</strong>
    </div>

    <form action="{{ route('admin.moderation.move-thread', $thread) }}" method="POST">
        @csrf
        
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow p-6 mb-6">
            <div class="mb-4">
                <label for="forum_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-1">Move to Forum *</label>
                <select name="forum_id" id="forum_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Select a forum...</option>
                    @foreach ($forums as $categoryId => $categoryForums)
                        <optgroup label="{{ $categoryForums->first()->category->name ?? 'Uncategorized' }}">
                            @foreach ($categoryForums as $forum)
                                <option value="{{ $forum->id }}" {{ $forum->id == $thread->forum_id ? 'disabled' : '' }}>
                                    {{ $forum->name }} {{ $forum->id == $thread->forum_id ? '(current)' : '' }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.moderation.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg dark:text-dark-text-primary text-light-text-primary hover:bg-gray-50">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">Move Thread</button>
        </div>
    </form>
</div>
@endsection
