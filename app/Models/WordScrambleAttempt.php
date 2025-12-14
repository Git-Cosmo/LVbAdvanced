<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordScrambleAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_scramble_game_id',
        'current_word_index',
        'total_score',
        'words_solved',
        'hints_used',
        'solved_words',
        'skipped_words',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'solved_words' => 'array',
        'skipped_words' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wordScrambleGame()
    {
        return $this->belongsTo(WordScrambleGame::class);
    }

    public function addSolvedWord($wordId, $timeTaken, $hintsUsed)
    {
        $solvedWords = $this->solved_words ?? [];
        $solvedWords[] = [
            'word_id' => $wordId,
            'time_taken' => $timeTaken,
            'hints_used' => $hintsUsed,
        ];

        $this->update([
            'solved_words' => $solvedWords,
            'words_solved' => count($solvedWords),
        ]);
    }

    public function skipWord($wordId)
    {
        $skippedWords = $this->skipped_words ?? [];
        $skippedWords[] = $wordId;

        $this->update([
            'skipped_words' => $skippedWords,
        ]);
    }

    public function canUseHint()
    {
        return true; // Can always use hint, but there's a penalty
    }
}
