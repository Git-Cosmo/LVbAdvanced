<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class MillionaireGame extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'difficulty',
        'time_limit',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function questions()
    {
        return $this->hasMany(MillionaireQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(MillionaireAttempt::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDifficultyColorAttribute()
    {
        return match ($this->difficulty) {
            'easy' => 'bg-green-500/20 text-green-400',
            'medium' => 'bg-yellow-500/20 text-yellow-400',
            'hard' => 'bg-red-500/20 text-red-400',
            default => 'bg-gray-500/20 text-gray-400',
        };
    }
}
