<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RssFeed extends Model
{
    protected $fillable = [
        'name',
        'url',
        'is_active',
        'refresh_interval',
        'last_fetched_at',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_fetched_at' => 'datetime',
        'settings' => 'array',
    ];

    /**
     * Get imported items from this feed.
     */
    public function importedItems(): HasMany
    {
        return $this->hasMany(RssImportedItem::class);
    }

    /**
     * Check if feed needs to be refreshed.
     */
    public function needsRefresh(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->last_fetched_at) {
            return true;
        }

        return $this->last_fetched_at->addMinutes($this->refresh_interval)->isPast();
    }
}
