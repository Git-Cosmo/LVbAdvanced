<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HandleApiErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            // Log the error with context
            Log::error('Request failed', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);

            // Return JSON error for API requests
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'error' => 'An error occurred while processing your request.',
                    'message' => config('app.debug') ? $e->getMessage() : 'Please try again later.',
                ], 500);
            }

            // Return user-friendly error for web requests
            return redirect()->back()
                ->with('error', 'An error occurred. Please try again.')
                ->withInput();
        }
    }
}
