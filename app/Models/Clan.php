<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Clan extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'tag',
        'slug',
        'description',
        'game',
        'logo_url',
        'banner_url',
        'owner_id',
        'is_public',
        'is_recruiting',
        'member_limit',
        'requirements',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_recruiting' => 'boolean',
        'requirements' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(ClanMember::class);
    }

    public function forums(): HasMany
    {
        return $this->hasMany(ClanForum::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(ClanEvent::class);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeRecruiting($query)
    {
        return $query->where('is_recruiting', true);
    }
}
