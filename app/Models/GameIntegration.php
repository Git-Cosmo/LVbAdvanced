<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameIntegration extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'platform_id',
        'username',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'metadata',
        'is_active',
        'last_synced_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'token_expires_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gameLibraries(): HasMany
    {
        return $this->hasMany(GameLibrary::class, 'integration_id');
    }
}
