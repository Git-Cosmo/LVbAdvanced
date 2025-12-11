<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventVenue extends Model
{
    protected $fillable = [
        'google_id',
        'name',
        'phone_number',
        'website',
        'review_count',
        'rating',
        'subtype',
        'subtypes',
        'full_address',
        'latitude',
        'longitude',
        'district',
        'street_number',
        'street',
        'city',
        'zipcode',
        'state',
        'country',
        'timezone',
        'google_mid',
    ];

    protected $casts = [
        'subtypes' => 'array',
        'review_count' => 'integer',
        'rating' => 'decimal:1',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Get the events that use this venue.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_venue', 'venue_id', 'event_id')
            ->withTimestamps();
    }
}
