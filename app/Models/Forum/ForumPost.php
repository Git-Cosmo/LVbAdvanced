<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'thread_id',
        'user_id',
        'reply_to_id',
        'content',
        'content_html',
        'is_approved',
        'is_hidden',
        'reactions_count',
        'edit_count',
        'edited_at',
        'edited_by',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_hidden' => 'boolean',
            'edited_at' => 'datetime',
        ];
    }

    /**
     * Get the thread that owns the post.
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    /**
     * Get the user that created the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the post this is replying to.
     */
    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'reply_to_id');
    }

    /**
     * Get the user who edited the post.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    /**
     * Get the reactions for this post.
     */
    public function reactions(): MorphMany
    {
        return $this->morphMany(ForumReaction::class, 'reactable');
    }

    /**
     * Get the attachments for this post.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(ForumAttachment::class, 'attachable');
    }

    /**
     * Get the reports for this post.
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(ForumReport::class, 'reportable');
    }
}
