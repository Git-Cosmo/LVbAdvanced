@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center py-20">
        <span class="text-6xl mb-4 block">🎮</span>
        <h1 class="text-3xl font-bold dark:text-dark-text-bright mb-4">Multiplayer Game in Progress</h1>
        <p class="dark:text-dark-text-secondary mb-6">Real-time multiplayer gameplay coming soon with Laravel Reverb!</p>
        <a href="{{ route('multiplayer.room', $room->code) }}" class="inline-block px-6 py-3 bg-accent-blue text-white rounded-lg hover:bg-accent-blue-bright">
            Back to Room
        </a>
    </div>
</div>
@endsection
