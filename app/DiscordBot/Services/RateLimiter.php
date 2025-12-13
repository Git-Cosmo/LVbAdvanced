<?php

namespace App\DiscordBot\Services;

use Illuminate\Support\Facades\Cache;

class RateLimiter
{
    /**
     * Check if a user has exceeded rate limits for a command.
     * 
     * @param string $userId Discord user ID
     * @param string $command Command name
     * @param int $maxAttempts Maximum attempts allowed
     * @param int $decaySeconds Time window in seconds
     * @return bool True if rate limit exceeded, false otherwise
     */
    public function tooManyAttempts(string $userId, string $command, int $maxAttempts = 3, int $decaySeconds = 60): bool
    {
        $key = $this->getRateLimitKey($userId, $command);
        $attempts = Cache::get($key, 0);
        
        return $attempts >= $maxAttempts;
    }
    
    /**
     * Increment the attempt count for a user command.
     * 
     * @param string $userId Discord user ID
     * @param string $command Command name
     * @param int $decaySeconds Time window in seconds
     * @return int New attempt count
     */
    public function hit(string $userId, string $command, int $decaySeconds = 60): int
    {
        $key = $this->getRateLimitKey($userId, $command);
        
        $attempts = Cache::get($key, 0) + 1;
        Cache::put($key, $attempts, $decaySeconds);
        
        return $attempts;
    }
    
    /**
     * Get remaining attempts for a user command.
     * 
     * @param string $userId Discord user ID
     * @param string $command Command name
     * @param int $maxAttempts Maximum attempts allowed
     * @return int Remaining attempts
     */
    public function remaining(string $userId, string $command, int $maxAttempts = 3): int
    {
        $key = $this->getRateLimitKey($userId, $command);
        $attempts = Cache::get($key, 0);
        
        return max(0, $maxAttempts - $attempts);
    }
    
    /**
     * Get the number of seconds until rate limit resets.
     * 
     * @param string $userId Discord user ID
     * @param string $command Command name
     * @param int $decaySeconds The decay seconds used when setting the limit
     * @return int Seconds until reset, or 0 if no limit
     */
    public function availableIn(string $userId, string $command, int $decaySeconds = 60): int
    {
        $key = $this->getRateLimitKey($userId, $command);
        
        if (!Cache::has($key)) {
            return 0;
        }
        
        // Try to get the actual TTL from the cache store if supported
        $store = Cache::getStore();
        // Redis and Memcached support getTtl (Laravel 8+), others may not
        if (method_exists($store, 'getTtl')) {
            $ttl = $store->getTtl($key);
            // getTtl may return null or negative if not found/expired
            if (is_int($ttl) && $ttl > 0) {
                return $ttl;
            }
        }
        // Fallback: return the configured decay seconds as an approximation
        return $decaySeconds;
    }
    
    /**
     * Clear rate limit for a user command.
     * 
     * @param string $userId Discord user ID
     * @param string $command Command name
     * @return void
     */
    public function clear(string $userId, string $command): void
    {
        $key = $this->getRateLimitKey($userId, $command);
        Cache::forget($key);
    }
    
    /**
     * Get the rate limit cache key.
     * 
     * @param string $userId Discord user ID
     * @param string $command Command name
     * @return string Cache key
     */
    protected function getRateLimitKey(string $userId, string $command): string
    {
        return "discord:ratelimit:{$userId}:{$command}";
    }
}
