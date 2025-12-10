@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">
            💬 Private Messages
        </h1>
        <a href="{{ route('forum.messaging.compose') }}" 
           class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition font-medium">
            ✉️ New Message
        </a>
    </div>
    
    @if($conversations->isEmpty())
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-12 text-center">
            <div class="text-6xl mb-4">📭</div>
            <h3 class="text-xl font-semibold dark:text-dark-text-bright text-light-text-bright mb-2">
                No messages yet
            </h3>
            <p class="text-dark-text-secondary mb-6">
                Start a conversation by sending a message to another user.
            </p>
            <a href="{{ route('forum.messaging.compose') }}" 
               class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition">
                Send Your First Message
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($conversations as $conversation)
                <a href="{{ route('forum.messaging.conversation', $conversation['conversation_id']) }}" 
                   class="block dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 hover:dark:bg-dark-bg-tertiary hover:bg-light-bg-tertiary transition">
                    <div class="flex items-start">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-2xl mr-4 flex-shrink-0">
                            {{ substr($conversation['other_user']->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold dark:text-dark-text-bright text-light-text-bright text-lg">
                                    {{ $conversation['other_user']->name }}
                                </h3>
                                <span class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                                    {{ $conversation['last_message']->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm truncate">
                                {{ Str::limit($conversation['last_message']->message, 120) }}
                            </p>
                            <div class="flex items-center space-x-4 mt-2">
                                @if($conversation['unread_count'] > 0)
                                    <span class="px-3 py-1 bg-accent-red text-white text-xs font-semibold rounded-full">
                                        {{ $conversation['unread_count'] }} new
                                    </span>
                                @endif
                                <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                                    {{ $conversation['message_count'] }} {{ Str::plural('message', $conversation['message_count']) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
