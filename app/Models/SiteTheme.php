<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SiteTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'effects',
        'start_date',
        'end_date',
        'is_active',
        'priority',
    ];

    protected $casts = [
        'effects' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the currently active theme
     */
    public static function getActiveTheme()
    {
        $today = Carbon::today();

        return static::where('is_active', true)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->orderByDesc('priority')
            ->first();
    }

    /**
     * Check if theme is currently valid (within date range)
     */
    public function isCurrentlyValid(): bool
    {
        $today = Carbon::today();

        return $this->start_date <= $today && $this->end_date >= $today;
    }

    /**
     * Scope for active themes
     */
    public function scopeActive($query)
    {
        $today = Carbon::today();

        return $query->where('is_active', true)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today);
    }
}
