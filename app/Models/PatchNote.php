<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class PatchNote extends Model implements Searchable
{
    use HasSlug;

    protected $fillable = [
        'game_name',
        'version',
        'title',
        'slug',
        'description',
        'content',
        'source_url',
        'external_id',
        'released_at',
        'is_published',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'released_at' => 'datetime',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['game_name', 'title'])
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope to get only published patch notes.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to get featured patch notes.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to filter by game name.
     */
    public function scopeForGame($query, string $gameName)
    {
        return $query->where('game_name', $gameName);
    }

    /**
     * Get the search result for this model.
     */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->title,
            route('patch-notes.show', $this->slug)
        );
    }
}
