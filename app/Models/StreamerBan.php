<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class StreamerBan extends Model
{
    use HasSlug;

    protected $fillable = [
        'username',
        'slug',
        'profile_url',
        'avatar_url',
        'total_bans',
        'last_ban',
        'longest_ban',
        'ban_history',
        'last_scraped_at',
        'is_published',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'ban_history' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'last_scraped_at' => 'datetime',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('username')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope a query to only include published streamers.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include featured streamers.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get streamers with the most bans.
     */
    public function scopeMostBanned($query)
    {
        return $query->orderBy('total_bans', 'desc');
    }

    /**
     * Get recently scraped streamers.
     */
    public function scopeRecentlyScraped($query)
    {
        return $query->orderBy('last_scraped_at', 'desc');
    }

    /**
     * Get the full streamerbans.com URL.
     */
    public function getStreamerBansUrlAttribute(): string
    {
        return $this->profile_url ?? 'https://streamerbans.com/user/' . $this->username;
    }
}
