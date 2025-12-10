<?php

namespace App\Models\Forum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumPoll extends Model
{
    protected $fillable = [
        'thread_id',
        'question',
        'is_multiple_choice',
        'is_public',
        'closes_at',
        'total_votes',
    ];

    protected $casts = [
        'is_multiple_choice' => 'boolean',
        'is_public' => 'boolean',
        'closes_at' => 'datetime',
    ];

    /**
     * Get the thread that owns the poll.
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    /**
     * Get the poll options.
     */
    public function options(): HasMany
    {
        return $this->hasMany(ForumPollOption::class, 'poll_id')->orderBy('order');
    }

    /**
     * Check if the poll is active.
     */
    public function isActive(): bool
    {
        if (!$this->closes_at) {
            return true;
        }
        
        return $this->closes_at->isFuture();
    }
}
