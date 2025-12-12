<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RedditPost extends Model
{
    use HasSlug;

    protected $fillable = [
        'reddit_id',
        'subreddit',
        'title',
        'body',
        'author',
        'flair',
        'url',
        'permalink',
        'score',
        'num_comments',
        'posted_at',
        'thumbnail',
        'media',
        'post_hint',
        'is_video',
        'is_self',
        'is_published',
        'is_featured',
        'views_count',
        'slug',
    ];

    protected $casts = [
        'media' => 'array',
        'is_video' => 'boolean',
        'is_self' => 'boolean',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'posted_at' => 'datetime',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
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
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include posts from a specific subreddit.
     */
    public function scopeSubreddit($query, $subreddit)
    {
        return $query->where('subreddit', $subreddit);
    }

    /**
     * Scope a query to only include video posts.
     */
    public function scopeVideos($query)
    {
        return $query->where('is_video', true);
    }

    /**
     * Scope a query to only include text posts.
     */
    public function scopeTextPosts($query)
    {
        return $query->where('is_self', true);
    }

    /**
     * Get the full Reddit URL.
     */
    public function getRedditUrlAttribute(): string
    {
        return 'https://reddit.com'.$this->permalink;
    }

    /**
     * Extract YouTube video ID from URL.
     */
    public function getYoutubeVideoId(): ?string
    {
        if (! $this->url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/', $this->url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
