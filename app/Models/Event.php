<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Event extends Model
{
    use HasSlug, HasTags;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'source',
        'source_url',
        'external_id',
        'event_type',
        'game_name',
        'start_date',
        'end_date',
        'location',
        'platform',
        'is_featured',
        'is_published',
        'views_count',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'views_count' => 'integer',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(100);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get imported items for this event.
     */
    public function importedItems(): HasMany
    {
        return $this->hasMany(EventImportedItem::class);
    }

    /**
     * Scope to only published events.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to only featured events.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->whereNotNull('start_date')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc');
    }

    /**
     * Scope for past events.
     */
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now())
            ->orderBy('start_date', 'desc');
    }

    /**
     * Scope for ongoing events.
     */
    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now())
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->orderBy('start_date', 'desc');
    }

    /**
     * Check if event is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->start_date && $this->start_date->isFuture();
    }

    /**
     * Check if event is ongoing.
     */
    public function isOngoing(): bool
    {
        if (!$this->start_date) {
            return false;
        }

        $hasStarted = $this->start_date->isPast();
        $hasNotEnded = !$this->end_date || $this->end_date->isFuture();

        return $hasStarted && $hasNotEnded;
    }

    /**
     * Check if event has ended.
     */
    public function isPast(): bool
    {
        return $this->end_date && $this->end_date->isPast();
    }

    /**
     * Get event status as string.
     */
    public function getStatusAttribute(): string
    {
        if ($this->isOngoing()) {
            return 'ongoing';
        } elseif ($this->isUpcoming()) {
            return 'upcoming';
        } elseif ($this->isPast()) {
            return 'past';
        }
        return 'unknown';
    }
}
