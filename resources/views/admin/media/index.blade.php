@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">
            Media Management
        </h1>
    </div>

    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Galleries</h2>
        <div class="space-y-4">
            @forelse($galleries as $gallery)
                <div class="flex items-center justify-between p-4 dark:bg-dark-bg-tertiary rounded">
                    <div>
                        <h3 class="font-semibold">{{ $gallery->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $gallery->game }} - by {{ $gallery->user->name }}</p>
                    </div>
                </div>
            @empty
                <p>No galleries found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
