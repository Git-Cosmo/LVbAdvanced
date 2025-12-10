@extends('layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Left Sidebar -->
    <aside class="col-span-12 lg:col-span-3 space-y-6">
        <!-- Welcome Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Welcome to FPSociety
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-4">
                Join the ultimate gaming community for Counter Strike 2, GTA V, Fortnite, and more. Share mods, compete, and connect!
            </p>
            @guest
                <div class="space-y-2">
                    <a href="/register" class="block w-full px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white text-center rounded-lg font-medium hover:shadow-lg transition-all">
                        Sign Up
                    </a>
                    <a href="/login" class="block w-full px-4 py-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-primary text-light-text-primary text-center rounded-lg font-medium dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-all">
                        Sign In
                    </a>
                </div>
            @else
                <p class="dark:text-dark-text-primary text-light-text-primary text-sm">
                    Welcome back, <strong>{{ auth()->user()->name }}</strong>!
                </p>
            @endguest
        </div>

        <!-- Stats Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Forum Statistics
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Members:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Forums:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\Forum::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Threads:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\ForumThread::count() }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Posts:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">{{ \App\Models\Forum\ForumPost::count() }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Links Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Quick Links
            </h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('forum.index') }}" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Forum Index
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Recent Posts
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Top Members
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center dark:text-dark-text-secondary text-light-text-secondary dark:hover:text-dark-text-accent hover:text-light-text-accent text-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Help & FAQ
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Center Content -->
    <div class="col-span-12 lg:col-span-6">
        <div class="space-y-6">
            <!-- Hero Welcome -->
            <div class="dark:bg-gradient-to-r from-dark-bg-secondary to-dark-bg-tertiary bg-gradient-to-r from-light-bg-secondary to-light-bg-tertiary rounded-lg shadow-md p-8">
                <h1 class="text-3xl font-bold dark:text-dark-text-bright text-light-text-bright mb-3">
                    Welcome to FPSociety Gaming Community
                </h1>
                <p class="dark:text-dark-text-secondary text-light-text-secondary mb-4">
                    The premier destination for FPS and gaming enthusiasts. Download custom maps for CS2, GTA V mods, Fortnite skins, and connect with gamers worldwide. Compete in tournaments, share gameplay, and level up your gaming experience!
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('forum.index') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-accent-blue to-accent-purple text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                        Explore Forums
                    </a>
                    <a href="{{ route('media.index') }}" class="inline-block px-6 py-2 dark:bg-dark-bg-elevated bg-light-bg-elevated dark:text-dark-text-bright text-light-text-bright rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all">
                        Browse Downloads
                    </a>
                </div>
            </div>

            <!-- Latest News -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    Gaming News & Updates
                </h3>
                <div class="space-y-4">
                    <article class="border-b dark:border-dark-border-primary border-light-border-primary pb-4 last:border-0">
                        <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary mb-2">
                            🎮 Welcome to FPSociety!
                        </h4>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-2">
                            Join thousands of gamers in our community! Download custom CS2 maps, GTA V mods, Fortnite skins, and more. Participate in tournaments, earn XP, and climb the leaderboards!
                        </p>
                        <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            Posted on {{ now()->format('M d, Y') }}
                        </span>
                    </article>
                    <article class="border-b dark:border-dark-border-primary border-light-border-primary pb-4 last:border-0">
                        <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary mb-2">
                            🏆 New Gamification System Live
                        </h4>
                        <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-2">
                            Earn XP, unlock achievements, and compete on seasonal leaderboards. Build your reputation and become a legend in the FPSociety community!
                        </p>
                        <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">
                            Posted on {{ now()->subDays(2)->format('M d, Y') }}
                        </span>
                    </article>
                </div>
            </div>

            <!-- Features Overview -->
            <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                    Community Features
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-blue to-accent-purple rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Game Downloads</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Maps, mods, skins & more</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-purple to-accent-pink rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">XP & Leveling</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Earn rewards for activity</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-green to-accent-teal rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Leaderboards</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Compete with gamers</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-accent-orange to-accent-red rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold dark:text-dark-text-primary text-light-text-primary text-sm">Tournaments</h4>
                            <p class="dark:text-dark-text-tertiary text-light-text-tertiary text-xs">Compete & win prizes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <aside class="col-span-12 lg:col-span-3 space-y-6">
        <!-- Online Users Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Who's Online
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Members:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">0</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Guests:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">1</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="dark:text-dark-text-secondary text-light-text-secondary text-sm">Total:</span>
                    <span class="dark:text-dark-text-accent text-light-text-accent font-semibold">1</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Recent Activity
            </h3>
            <div class="space-y-3 text-sm">
                <div class="border-b dark:border-dark-border-primary border-light-border-primary pb-3 last:border-0">
                    <p class="dark:text-dark-text-secondary text-light-text-secondary">
                        Welcome to the portal! Start exploring the forums.
                    </p>
                    <span class="text-xs dark:text-dark-text-tertiary text-light-text-tertiary">Just now</span>
                </div>
            </div>
        </div>

        <!-- Community Info Block -->
        <div class="dark:bg-dark-bg-secondary bg-light-bg-secondary rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold dark:text-dark-text-bright text-light-text-bright mb-4 border-b dark:border-dark-border-primary border-light-border-primary pb-2">
                Popular Games
            </h3>
            <p class="dark:text-dark-text-secondary text-light-text-secondary text-sm mb-4">
                Find content, discussions, and downloads for your favorite games!
            </p>
            <div class="flex flex-wrap gap-2">
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">CS2</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">GTA V</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Fortnite</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Call of Duty</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Minecraft</span>
                <span class="px-2 py-1 dark:bg-dark-bg-tertiary bg-light-bg-tertiary dark:text-dark-text-accent text-light-text-accent text-xs rounded">Valorant</span>
            </div>
        </div>
    </aside>
</div>
@endsection
