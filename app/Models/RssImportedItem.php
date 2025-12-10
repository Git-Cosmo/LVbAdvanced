<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RssImportedItem extends Model
{
    protected $fillable = [
        'rss_feed_id',
        'guid',
        'news_id',
    ];

    /**
     * Get the RSS feed for this item.
     */
    public function rssFeed(): BelongsTo
    {
        return $this->belongsTo(RssFeed::class);
    }

    /**
     * Get the news article created from this item.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
