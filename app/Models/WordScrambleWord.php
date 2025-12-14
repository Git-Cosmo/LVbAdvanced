<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordScrambleWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'word_scramble_game_id',
        'word',
        'hint',
        'category',
        'difficulty_level',
        'order',
    ];

    public function game()
    {
        return $this->belongsTo(WordScrambleGame::class, 'word_scramble_game_id');
    }

    public function getScrambledWordAttribute()
    {
        $word = strtoupper($this->word);
        $chars = str_split($word);
        
        // Shuffle until it's different from original
        $scrambled = $chars;
        $attempts = 0;
        do {
            shuffle($scrambled);
            $attempts++;
        } while (implode('', $scrambled) === $word && $attempts < 10);
        
        return implode('', $scrambled);
    }

    public function getCategoryIconAttribute()
    {
        return match ($this->category) {
            'game' => '🎮',
            'character' => '👤',
            'streamer' => '📺',
            'esports_team' => '🏆',
            'platform' => '💻',
            'weapon' => '⚔️',
            'map' => '🗺️',
            default => '🎯',
        };
    }
}
