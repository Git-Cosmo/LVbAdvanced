<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlockSetting extends Model
{
    protected $fillable = [
        'block_id',
        'key',
        'value',
        'type',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
