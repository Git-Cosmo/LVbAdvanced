<?php

namespace App\Providers;

use App\Events\RealtimeNotificationCreated;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Socialite providers
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('steam', \SocialiteProviders\Steam\Provider::class);
            $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
            $event->extendSocialite('battlenet', \SocialiteProviders\Battlenet\Provider::class);
        });

        DatabaseNotification::created(function (DatabaseNotification $notification) {
            broadcast(new RealtimeNotificationCreated($notification));
        });

        // Register Discord bot event listeners
        Event::listen(
            \App\Events\AnnouncementCreated::class,
            \App\Listeners\SendAnnouncementToDiscord::class,
        );
    }
}
