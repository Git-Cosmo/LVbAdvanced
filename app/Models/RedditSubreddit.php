<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedditSubreddit extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'is_enabled',
        'content_type',
        'scrape_limit',
        'last_scraped_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'last_scraped_at' => 'datetime',
    ];

    /**
     * Scope a query to only include enabled subreddits.
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    /**
     * Get posts from this subreddit.
     */
    public function posts()
    {
        return $this->hasMany(RedditPost::class, 'subreddit', 'name');
    }
}
