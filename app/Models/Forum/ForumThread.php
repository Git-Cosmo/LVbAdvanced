<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class ForumThread extends Model
{
    use SoftDeletes, HasSlug, HasTags;

    protected $fillable = [
        'forum_id',
        'user_id',
        'title',
        'slug',
        'is_pinned',
        'is_locked',
        'is_hidden',
        'views_count',
        'posts_count',
        'reactions_count',
        'last_post_id',
        'last_post_at',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'is_locked' => 'boolean',
            'is_hidden' => 'boolean',
            'last_post_at' => 'datetime',
        ];
    }

    /**
     * Get the forum that owns the thread.
     */
    public function forum(): BelongsTo
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    /**
     * Get the user that created the thread.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the posts in this thread.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'thread_id');
    }

    /**
     * Get the last post in this thread.
     */
    public function lastPost(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'last_post_id');
    }

    /**
     * Get the poll for this thread.
     */
    public function poll(): HasOne
    {
        return $this->hasOne(ForumPoll::class, 'thread_id');
    }

    /**
     * Get the reactions for this thread.
     */
    public function reactions(): MorphMany
    {
        return $this->morphMany(ForumReaction::class, 'reactable');
    }

    /**
     * Get the subscriptions for this thread.
     */
    public function subscriptions(): MorphMany
    {
        return $this->morphMany(ForumSubscription::class, 'subscribable');
    }

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
     * Increment the views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
