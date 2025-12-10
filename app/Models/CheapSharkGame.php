<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CheapSharkGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'cheapshark_id',
        'title',
        'slug',
        'thumbnail',
        'cheapest_price',
    ];

    protected $casts = [
        'cheapest_price' => 'float',
    ];

    public function deals(): HasMany
    {
        return $this->hasMany(CheapSharkDeal::class, 'game_id');
    }

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(
            CheapSharkStore::class,
            'cheap_shark_deals',
            'game_id',
            'store_id'
        )->withTimestamps();
    }
}
