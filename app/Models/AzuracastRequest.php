<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzuracastRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_id',
        'requested_at',
        'status',
        'api_response_message',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
    ];
}
