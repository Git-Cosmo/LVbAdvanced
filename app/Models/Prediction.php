<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'options',
        'correct_option_index',
        'points_reward',
        'closes_at',
        'resolves_at',
        'status',
    ];

    protected $casts = [
        'options' => 'array',
        'closes_at' => 'datetime',
        'resolves_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($prediction) {
            if (empty($prediction->slug)) {
                $prediction->slug = Str::slug($prediction->title);
            }
        });
    }

    public function entries()
    {
        return $this->hasMany(PredictionEntry::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open')
            ->where('closes_at', '>', now());
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function getCorrectOptionAttribute()
    {
        return isset($this->correct_option_index)
            ? $this->options[$this->correct_option_index]
            : null;
    }

    public function getTotalEntriesAttribute()
    {
        return $this->entries()->count();
    }
}
