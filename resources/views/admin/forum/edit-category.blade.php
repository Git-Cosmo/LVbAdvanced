@extends('admin.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">Edit Category</h1>
    </div>
    
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
        <form action="{{ route('admin.forum.category.update', $category) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Name *
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $category->name) }}"
                       class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('name') ring-2 ring-accent-red @enderror"
                       required>
                @error('name')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Slug *
                </label>
                <input type="text" 
                       id="slug" 
                       name="slug" 
                       value="{{ old('slug', $category->slug) }}"
                       class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue @error('slug') ring-2 ring-accent-red @enderror"
                       required>
                @error('slug')
                <p class="mt-2 text-sm text-accent-red">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue">{{ old('description', $category->description) }}</textarea>
            </div>
            
            <div class="mb-6">
                <label for="order" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                    Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', $category->order) }}"
                       class="w-full px-4 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-blue">
            </div>
            
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-accent-blue focus:ring-accent-blue rounded">
                    <span class="ml-2 text-sm dark:text-dark-text-primary text-light-text-primary">Active</span>
                </label>
            </div>
            
            <div class="flex items-center justify-between pt-6 border-t dark:border-dark-border-primary border-light-border-primary">
                <a href="{{ route('admin.forum.index') }}" 
                   class="px-6 py-3 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg hover:bg-opacity-80 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
