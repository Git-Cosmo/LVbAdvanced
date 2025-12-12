<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameServer extends Model
{
    protected $fillable = [
        'name',
        'game',
        'game_short_code',
        'description',
        'ip_address',
        'port',
        'connect_url',
        'status',
        'max_players',
        'current_players',
        'map',
        'game_mode',
        'metadata',
        'icon_color_from',
        'icon_color_to',
        'display_order',
        'is_featured',
        'is_active',
        'last_ping_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'last_ping_at' => 'datetime',
    ];

    /**
     * Scope to get only active servers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get featured servers.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to order by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    /**
     * Get the full connect address.
     */
    public function getConnectAddressAttribute(): ?string
    {
        if ($this->connect_url) {
            return $this->connect_url;
        }

        if ($this->ip_address && $this->port) {
            return "{$this->ip_address}:{$this->port}";
        }

        return null;
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'online' => 'emerald',
            'offline' => 'rose',
            'maintenance' => 'amber',
            'coming_soon' => 'yellow',
            default => 'gray',
        };
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'online' => '● Online',
            'offline' => '○ Offline',
            'maintenance' => '⚠ Maintenance',
            'coming_soon' => 'Soon',
            default => 'Unknown',
        };
    }
}
