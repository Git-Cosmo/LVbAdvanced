<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Update last_active_at every 5 minutes to reduce database writes
            $user = Auth::user();
            $lastActive = $user->last_active_at;
            
            if (!$lastActive || $lastActive->diffInMinutes(now()) >= 5) {
                $user->update(['last_active_at' => now()]);
            }
        }

        return $next($request);
    }
}
