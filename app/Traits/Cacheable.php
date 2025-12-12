<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    /**
     * Cache the result of a query with automatic tag management.
     *
     * @param  string  $key  Cache key
     * @param  int  $ttl  Time to live in seconds (default: 1 hour)
     * @param  callable  $callback  Query callback
     * @param  array  $tags  Optional cache tags for easier clearing
     * @return mixed The result returned by the callback
     */
    protected function cacheQuery(string $key, int $ttl = 3600, callable $callback, array $tags = [])
    {
        if (empty($tags)) {
            return Cache::remember($key, $ttl, $callback);
        }

        return Cache::tags($tags)->remember($key, $ttl, $callback);
    }

    /**
     * Clear cache by key.
     */
    protected function forgetCache(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Clear cache by tags.
     */
    protected function forgetCacheTags(array $tags): bool
    {
        return Cache::tags($tags)->flush();
    }

    /**
     * Clear multiple cache keys at once.
     */
    protected function forgetMultiple(array $keys): void
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}
