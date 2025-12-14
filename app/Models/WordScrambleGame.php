<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WordScrambleGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'difficulty',
        'time_per_word',
        'words_per_game',
        'hint_penalty',
        'points_per_word',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->title);
            }
        });
    }

    public function words()
    {
        return $this->hasMany(WordScrambleWord::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(WordScrambleAttempt::class);
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
