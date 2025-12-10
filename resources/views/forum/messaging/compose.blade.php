@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto" x-data="{ message: '' }">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright">
            ✉️ New Message
        </h1>
        <a href="{{ route('forum.messaging.inbox') }}" 
           class="text-dark-text-accent hover:text-dark-text-bright">
            Cancel
        </a>
    </div>
    
    <form action="{{ route('forum.messaging.send') }}" method="POST" class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl p-8">
        @csrf
        
        <div class="mb-6">
            <label for="recipient_id" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                To
            </label>
            @if($recipient)
                <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
                <div class="flex items-center space-x-3 p-4 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-accent-blue to-accent-purple flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($recipient->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold dark:text-dark-text-bright text-light-text-bright">{{ $recipient->name }}</p>
                        <a href="{{ route('profile.show', $recipient) }}" class="text-sm text-dark-text-accent hover:underline">View Profile</a>
                    </div>
                </div>
            @else
                <select id="recipient_id" 
                        name="recipient_id" 
                        required
                        class="w-full px-4 py-3 border dark:border-dark-border-secondary border-light-border-secondary rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary focus:ring-2 focus:ring-purple-500">
                    <option value="">Select a user...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            @endif
            @error('recipient_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="message" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                Message
            </label>
            <textarea id="message"
                      name="message"
                      rows="10"
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
            <div class="space-x-4">
                <a href="{{ route('forum.messaging.inbox') }}" 
                   class="px-6 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary rounded-lg hover:dark:bg-dark-border-secondary hover:bg-light-border-secondary transition font-medium inline-block">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition font-medium">
                    Send Message
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
