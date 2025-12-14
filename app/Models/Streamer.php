<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streamer extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'username',
        'display_name',
        'profile_image_url',
        'channel_url',
        'is_live',
        'viewer_count',
        'stream_title',
        'game_name',
        'thumbnail_url',
        'stream_started_at',
        'last_checked_at',
    ];

    protected $casts = [
        'is_live' => 'boolean',
        'viewer_count' => 'integer',
        'stream_started_at' => 'datetime',
        'last_checked_at' => 'datetime',
    ];

    public function scopeLive($query)
    {
        return $query->where('is_live', true);
    }

    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeTopViewers($query, $limit = 20)
    {
        return $query->orderByDesc('viewer_count')->limit($limit);
    }

    public function getFormattedViewersAttribute()
    {
        if ($this->viewer_count >= 1000) {
            return round($this->viewer_count / 1000, 1).'K';
        }
        return $this->viewer_count;
    }
}
