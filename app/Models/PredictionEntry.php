<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredictionEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prediction_id',
        'selected_option_index',
        'points_wagered',
        'is_correct',
        'points_won',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prediction()
    {
        return $this->belongsTo(Prediction::class);
    }

    public function getSelectedOptionAttribute()
    {
        return $this->prediction->options[$this->selected_option_index] ?? null;
    }
}
