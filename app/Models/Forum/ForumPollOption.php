<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumPollOption extends Model
{
    protected $fillable = [
        'poll_id',
        'option_text',
        'votes_count',
        'order',
    ];

    /**
     * Get the poll that owns the option.
     */
    public function poll(): BelongsTo
    {
        return $this->belongsTo(ForumPoll::class, 'poll_id');
    }

    /**
     * Get the votes for this option.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(ForumPollVote::class, 'option_id');
    }

    /**
     * Get the percentage of votes for this option.
     */
    public function getPercentageAttribute(): float
    {
        if ($this->poll->total_votes === 0) {
            return 0;
        }
        
        return round(($this->votes_count / $this->poll->total_votes) * 100, 1);
    }
}
