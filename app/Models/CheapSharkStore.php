<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CheapSharkStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'cheapshark_id',
        'name',
        'is_active',
        'logo',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function deals(): HasMany
    {
        return $this->hasMany(CheapSharkDeal::class, 'store_id');
    }

    public function games(): HasManyThrough
    {
        return $this->hasManyThrough(
            CheapSharkGame::class,
            CheapSharkDeal::class,
            'store_id',
            'id',
            'id',
            'game_id'
        )->distinct();
    }
}
