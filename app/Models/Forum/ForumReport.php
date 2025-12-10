<?php

namespace App\Models\Forum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ForumReport extends Model
{
    protected $fillable = [
        'reportable_id',
        'reportable_type',
        'reporter_id',
        'reason',
        'status',
        'moderator_id',
        'moderator_notes',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the reporter.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the moderator.
     */
    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    /**
     * Get the reportable model.
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if the report is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Mark the report as resolved.
     */
    public function resolve(User $moderator, ?string $notes = null): void
    {
        $this->update([
            'status' => 'resolved',
            'moderator_id' => $moderator->id,
            'moderator_notes' => $notes,
            'resolved_at' => now(),
        ]);
    }
}
