@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-dark-bg-primary bg-light-bg-primary py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4">
                Contact Us
            </h1>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-lg">
                Have a question or need help? We're here for you!
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Form -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
                    Send us a Message
                </h2>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500 rounded-lg">
                        <p class="text-green-500">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Your Name *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name ?? '') }}"
                               required
                               class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary border dark:border-dark-border-primary border-light-border-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Email Address *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', auth()->user()->email ?? '') }}"
                               required
                               class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary border dark:border-dark-border-primary border-light-border-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Subject *
                        </label>
                        <select id="subject" 
                                name="subject" 
                                required
                                class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary border dark:border-dark-border-primary border-light-border-primary focus:outline-none focus:ring-2 focus:ring-accent-blue">
                            <option value="">Select a subject</option>
                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                            <option value="abuse" {{ old('subject') == 'abuse' ? 'selected' : '' }}>Report Abuse</option>
                            <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback/Suggestions</option>
                            <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership Inquiry</option>
                            <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium dark:text-dark-text-primary text-light-text-primary mb-2">
                            Message *
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="6" 
                                  required
                                  class="w-full px-4 py-2 rounded-lg dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary border dark:border-dark-border-primary border-light-border-primary focus:outline-none focus:ring-2 focus:ring-accent-blue resize-none">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-accent-blue hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-6">
                <!-- Quick Info -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
                        Get in Touch
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Community Support -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-accent-blue/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-1">
                                    Community Forums
                                </h3>
                                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                                    Join our forums to connect with other gamers and get help from the community.
                                </p>
                                <a href="{{ route('forum.index') }}" class="text-accent-blue hover:underline mt-2 inline-block">
                                    Visit Forums →
                                </a>
                            </div>
                        </div>

                        <!-- FAQ -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-accent-purple/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-1">
                                    Need Quick Help?
                                </h3>
                                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                                    Check out our help documentation and frequently asked questions.
                                </p>
                            </div>
                        </div>

                        <!-- Response Time -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-accent-green/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-accent-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold dark:text-dark-text-bright text-light-text-bright mb-1">
                                    Response Time
                                </h3>
                                <p class="dark:text-dark-text-secondary text-light-text-secondary">
                                    We typically respond to inquiries within 24-48 hours during business days.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold dark:text-dark-text-bright text-light-text-bright mb-6">
                        Connect With Us
                    </h2>
                    
                    <div class="space-y-4">
                        <p class="dark:text-dark-text-secondary text-light-text-secondary">
                            Follow us on social media for the latest updates, news, and community highlights.
                        </p>
                        
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center space-x-2 px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg opacity-50 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                <span>Twitter (Coming Soon)</span>
                            </div>
                            
                            <div class="flex items-center space-x-2 px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary rounded-lg opacity-50 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
                                </svg>
                                <span>Discord (Coming Soon)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
