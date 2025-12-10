<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ForumReaction extends Model
{
    protected $fillable = [
        'user_id',
        'reactable_id',
        'reactable_type',
        'type',
    ];

    /**
     * Get the user who created the reaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reactable model (post, thread, etc.).
     */
    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }
}
