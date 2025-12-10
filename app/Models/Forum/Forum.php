<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forum extends Model
{
    protected $fillable = [
        'category_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'order',
        'is_active',
        'is_locked',
        'threads_count',
        'posts_count',
        'last_post_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_locked' => 'boolean',
        ];
    }

    /**
     * Get the category that owns the forum.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    /**
     * Get the parent forum.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Forum::class, 'parent_id');
    }

    /**
     * Get the child forums.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Forum::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get the threads in this forum.
     */
    public function threads(): HasMany
    {
        return $this->hasMany(ForumThread::class, 'forum_id');
    }

    /**
     * Get the last post in this forum.
     */
    public function lastPost(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'last_post_id');
    }

    /**
     * Scope to get only active forums.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
