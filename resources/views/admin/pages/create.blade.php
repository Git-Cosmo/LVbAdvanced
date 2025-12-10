@extends('admin.layouts.app')

@section('title', 'Create Page')
@section('header', 'Create New Page')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.pages.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('slug') border-red-500 @enderror">
            <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from title</p>
            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label for="layout" class="block text-sm font-medium text-gray-700">Layout *</label>
                <select name="layout" id="layout" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="default" {{ old('layout') == 'default' ? 'selected' : '' }}>Default</option>
                    <option value="full-width" {{ old('layout') == 'full-width' ? 'selected' : '' }}>Full Width</option>
                </select>
            </div>
        </div>

        <div>
            <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
            <textarea name="meta_description" id="meta_description" rows="2"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('meta_description') }}</textarea>
        </div>

        <div>
            <label for="meta_keywords" class="block text-sm font-medium text-gray-700">Meta Keywords</label>
            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
        </div>

        <div>
            <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
            <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
        </div>

        <div class="flex items-center space-x-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-700">Active</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_homepage" value="1" {{ old('is_homepage') ? 'checked' : '' }}
                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <span class="ml-2 text-sm text-gray-700">Set as Homepage</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition">
                Create Page
            </button>
        </div>
    </form>
</div>
@endsection
