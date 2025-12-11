<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTicketLink extends Model
{
    protected $fillable = [
        'event_id',
        'source',
        'link',
        'fav_icon',
    ];

    /**
     * Get the event that owns this ticket link.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
