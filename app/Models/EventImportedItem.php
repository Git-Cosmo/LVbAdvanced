<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventImportedItem extends Model
{
    protected $fillable = [
        'source',
        'external_id',
        'event_id',
    ];

    /**
     * Get the event that this import belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
