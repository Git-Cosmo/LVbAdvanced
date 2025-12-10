<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Update user's last activity timestamp (throttled to once per minute)
            $cacheKey = 'user_activity_' . Auth::id();
            
            if (!Cache::has($cacheKey)) {
                Auth::user()->update(['last_active_at' => now()]);
                Cache::put($cacheKey, true, 60); // Cache for 1 minute
            }
        } else {
            // Track guest count
            $guestKey = 'guest_' . $request->ip();
            if (!Cache::has($guestKey)) {
                Cache::put($guestKey, true, 900); // 15 minutes
                Cache::increment('online_guests_count');
            }
        }
        
        return $next($request);
    }
}
