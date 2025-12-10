<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Block extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'type',
        'title',
        'show_title',
        'content',
        'config',
        'cache_lifetime',
        'template',
        'visibility',
        'visibility_roles',
        'html_class',
        'html_id',
        'is_active',
    ];

    protected $casts = [
        'show_title' => 'boolean',
        'is_active' => 'boolean',
        'config' => 'array',
        'visibility_roles' => 'array',
    ];

    public function positions(): HasMany
    {
        return $this->hasMany(BlockPosition::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(BlockSetting::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'type', 'is_active'])
            ->logOnlyDirty();
    }

    public function getSetting(string $key, mixed $default = null): mixed
    {
        $setting = $this->settings()->where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return match($setting->type) {
            'integer' => (int) $setting->value,
            'boolean' => (bool) $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    public function setSetting(string $key, mixed $value, string $type = 'string'): void
    {
        $this->settings()->updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'type' => $type,
            ]
        );
    }
}
