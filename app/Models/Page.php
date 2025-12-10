<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'layout',
        'is_active',
        'is_homepage',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_homepage' => 'boolean',
    ];

    public function blockPositions(): HasMany
    {
        return $this->hasMany(BlockPosition::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(BlockPosition::class)->with('block');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'slug', 'is_active', 'is_homepage'])
            ->logOnlyDirty();
    }

    public static function getHomepage(): ?self
    {
        return static::where('is_homepage', true)
            ->where('is_active', true)
            ->first();
    }
}
