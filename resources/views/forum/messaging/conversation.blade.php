@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ message: '' }">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('forum.messaging.inbox') }}" 
               class="text-dark-text-accent hover:text-dark-text-bright">
                ← Back to Inbox
            </a>
            <div class="w-px h-6 bg-gray-600"></div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-lg">
                    {{ substr($otherUser->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright">
                        {{ $otherUser->name }}
                    </h1>
                    <a href="{{ route('profile.show', $otherUser) }}" 
                       class="text-sm text-dark-text-accent hover:underline">
                        View Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Messages Container -->
    <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6 mb-6">
        <div class="space-y-4 max-h-[600px] overflow-y-auto">
            @foreach($messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[70%]">
                        <div class="flex items-end space-x-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                {{ substr($message->sender->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="px-4 py-3 rounded-lg {{ $message->sender_id === auth()->id() ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' : 'dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary' }}">
                                    <p class="text-sm whitespace-pre-wrap break-words">{{ $message->message }}</p>
                                </div>
                                <p class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary mt-1 {{ $message->sender_id === auth()->id() ? 'text-right' : '' }}">
                                    {{ $message->created_at->format('M d, Y g:i A') }}
                                    @if($message->sender_id === auth()->id() && $message->is_read)
                                        <span class="ml-2">✓ Read</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Reply Form -->
    <form action="{{ route('forum.messaging.send') }}" method="POST" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-6">
        @csrf
        <input type="hidden" name="recipient_id" value="{{ $otherUser->id }}">
        <input type="hidden" name="conversation_id" value="{{ $conversationId }}">
        
        <div class="mb-4">
            <label for="message" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                Your Reply
            </label>
            <textarea id="message"
                      name="message"
                      rows="4"
                      x-model="message"
                      required
                      class="w-full px-4 py-3 border dark:border-dark-border-secondary border-light-border-secondary rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                      placeholder="Type your message..."></textarea>
            @error('message')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex items-center justify-between">
            <div class="text-sm dark:text-dark-text-secondary text-light-text-secondary">
                <span x-text="message.length"></span> / 10,000 characters
            </div>
            <button type="submit" 
                    class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition font-medium">
                Send Message
            </button>
        </div>
    </form>
</div>
@endsection
