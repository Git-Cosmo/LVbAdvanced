<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumPollVote extends Model
{
    protected $fillable = [
        'poll_id',
        'option_id',
        'user_id',
    ];

    /**
     * Get the poll.
     */
    public function poll(): BelongsTo
    {
        return $this->belongsTo(ForumPoll::class, 'poll_id');
    }

    /**
     * Get the option.
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(ForumPollOption::class, 'option_id');
    }

    /**
     * Get the user who voted.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
