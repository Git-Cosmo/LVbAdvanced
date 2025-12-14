<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoguessrLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'geoguessr_game_id',
        'name',
        'country',
        'latitude',
        'longitude',
        'image_url',
        'hint',
        'difficulty_rating',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function geoguessrGame()
    {
        return $this->belongsTo(GeoguessrGame::class);
    }

    public function calculateDistance($guessLat, $guessLng)
    {
        $earthRadius = 6371; // km

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($guessLat);
        $lonTo = deg2rad($guessLng);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function calculateScore($guessLat, $guessLng, $maxPoints = 5000)
    {
        $distance = $this->calculateDistance($guessLat, $guessLng);
        
        // Score decreases exponentially with distance
        // Perfect score for distance < 1 km
        // Zero score for distance > 5000 km
        if ($distance < 1) {
            return $maxPoints;
        }
        
        $score = $maxPoints * exp(-$distance / 500);
        return max(0, round($score));
    }
}
