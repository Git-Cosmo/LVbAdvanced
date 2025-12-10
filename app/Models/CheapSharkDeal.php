<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheapSharkDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'store_id',
        'game_id',
        'sale_price',
        'normal_price',
        'savings',
        'deal_rating',
        'steam_app_id',
        'on_sale',
        'deal_link',
    ];

    protected $casts = [
        'sale_price' => 'float',
        'normal_price' => 'float',
        'savings' => 'float',
        'on_sale' => 'boolean',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(CheapSharkStore::class, 'store_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(CheapSharkGame::class, 'game_id');
    }
}
