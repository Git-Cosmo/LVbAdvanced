<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model
{
    use HasSlug;

    protected $fillable = [
        'event_id',
        'name',
        'slug',
        'link',
        'description',
        'language',
        'date_human_readable',
        'start_time',
        'start_time_utc',
        'start_time_precision_sec',
        'end_time',
        'end_time_utc',
        'end_time_precision_sec',
        'is_virtual',
        'thumbnail',
        'publisher',
        'publisher_favicon',
        'publisher_domain',
        'event_type',
        'is_featured',
        'is_published',
        'views_count',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'start_time_utc' => 'datetime',
        'end_time' => 'datetime',
        'end_time_utc' => 'datetime',
        'start_time_precision_sec' => 'integer',
        'end_time_precision_sec' => 'integer',
        'is_virtual' => 'boolean',
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
            ->generateSlugsFrom('name')
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
     * Get ticket links for this event.
     */
    public function ticketLinks(): HasMany
    {
        return $this->hasMany(EventTicketLink::class);
    }

    /**
     * Get info links for this event.
     */
    public function infoLinks(): HasMany
    {
        return $this->hasMany(EventInfoLink::class);
    }

    /**
     * Get venues for this event.
     */
    public function venues(): BelongsToMany
    {
        return $this->belongsToMany(EventVenue::class, 'event_venue', 'event_id', 'venue_id')
            ->withTimestamps();
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
        return $query->whereNotNull('start_time')
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc');
    }

    /**
     * Scope for past events.
     */
    public function scopePast($query)
    {
        return $query->where('end_time', '<', now())
            ->orderBy('start_time', 'desc');
    }

    /**
     * Scope for ongoing events.
     */
    public function scopeOngoing($query)
    {
        return $query->where('start_time', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_time')
                    ->orWhere('end_time', '>=', now());
            })
            ->orderBy('start_time', 'desc');
    }

    /**
     * Check if event is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->start_time && $this->start_time->isFuture();
    }

    /**
     * Check if event is ongoing.
     */
    public function isOngoing(): bool
    {
        if (! $this->start_time) {
            return false;
        }

        $hasStarted = $this->start_time->isPast();
        $hasNotEnded = ! $this->end_time || $this->end_time->isFuture();

        return $hasStarted && $hasNotEnded;
    }

    /**
     * Check if event has ended.
     */
    public function isPast(): bool
    {
        return $this->end_time && $this->end_time->isPast();
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

    /**
     * Get RSVPs for this event.
     */
    public function rsvps(): HasMany
    {
        return $this->hasMany(EventRsvp::class);
    }

    /**
     * Get count of users going to this event.
     */
    public function goingCount(): int
    {
        return $this->rsvps()->where('status', 'going')->count();
    }

    /**
     * Get count of users interested in this event.
     */
    public function interestedCount(): int
    {
        return $this->rsvps()->where('status', 'interested')->count();
    }

    /**
     * Check if a user has RSVPed to this event.
     */
    public function hasUserRsvped(?int $userId): bool
    {
        if (!$userId) {
            return false;
        }

        return $this->rsvps()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's RSVP status for this event.
     */
    public function getUserRsvpStatus(?int $userId): ?string
    {
        if (!$userId) {
            return null;
        }

        $rsvp = $this->rsvps()->where('user_id', $userId)->first();
        return $rsvp?->status;
    }
}
