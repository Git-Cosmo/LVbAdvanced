<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TriviaGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'difficulty',
        'time_limit',
        'points_per_correct',
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

        static::creating(function ($triviaGame) {
            if (empty($triviaGame->slug)) {
                $triviaGame->slug = Str::slug($triviaGame->title);
            }
        });
    }

    public function questions()
    {
        return $this->hasMany(TriviaQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(TriviaAttempt::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDifficultyColorAttribute()
    {
        return match ($this->difficulty) {
            'easy' => 'text-green-500',
            'medium' => 'text-yellow-500',
            'hard' => 'text-red-500',
            default => 'text-gray-500',
        };
    }
}
