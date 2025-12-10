<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;

class Gallery extends Model
{
    use HasTags;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'game',
        'category',
        'views',
        'downloads',
    ];

    protected $casts = [
        'views' => 'integer',
        'downloads' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(GalleryComment::class);
    }
}
