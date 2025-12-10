<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ForumSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'subscribable_id',
        'subscribable_type',
        'notify_email',
        'notify_push',
    ];

    protected $casts = [
        'notify_email' => 'boolean',
        'notify_push' => 'boolean',
    ];

    /**
     * Get the user who created the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscribable model (thread, forum).
     */
    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }
}
