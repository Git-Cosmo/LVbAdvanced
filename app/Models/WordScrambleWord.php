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
        
        // For very short words (2-3 chars), limited permutations exist
        // Return original if word is too short to scramble meaningfully
        if (strlen($word) < 3) {
            return $word;
        }
        
        // Shuffle until it's different from original
        $scrambled = $chars;
        $attempts = 0;
        $maxAttempts = 20;
        
        do {
            shuffle($scrambled);
            $attempts++;
        } while (implode('', $scrambled) === $word && $attempts < $maxAttempts);
        
        // If we couldn't find a different scramble after max attempts, swap first two characters
        if (implode('', $scrambled) === $word && strlen($word) >= 2) {
            $temp = $scrambled[0];
            $scrambled[0] = $scrambled[1];
            $scrambled[1] = $temp;
        }
        
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
