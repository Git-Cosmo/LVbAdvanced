<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $table = 'gallery_media';

    protected $fillable = [
        'gallery_id',
        'path',
        'url',
        'thumbnail',
        'size',
        'mime',
        'name',
        'type',
        'game',
        'downloads',
    ];

    protected $casts = [
        'size' => 'integer',
        'downloads' => 'integer',
    ];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
}
