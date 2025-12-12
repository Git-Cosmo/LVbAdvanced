<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPointsLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source_type',
        'source_id',
        'points_change',
        'balance_after',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->latest()->limit($limit);
    }
}
