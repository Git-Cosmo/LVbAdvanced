<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfilePost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'profile_user_id',
        'author_id',
        'content',
        'is_approved',
        'reactions_count',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the user whose profile this post is on.
     */
    public function profileUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'profile_user_id');
    }

    /**
     * Get the author of the post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the reactions for this profile post.
     */
    public function reactions(): MorphMany
    {
        return $this->morphMany(\App\Models\Forum\ForumReaction::class, 'reactable');
    }
}
