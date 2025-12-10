<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlbumPhoto extends Model
{
    protected $fillable = [
        'album_id',
        'path',
        'url',
        'thumbnail',
        'caption',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
