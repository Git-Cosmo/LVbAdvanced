<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventInfoLink extends Model
{
    protected $fillable = [
        'event_id',
        'source',
        'link',
    ];

    /**
     * Get the event that owns this info link.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
