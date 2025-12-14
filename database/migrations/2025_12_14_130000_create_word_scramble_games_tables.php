<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Word Scramble Game
        Schema::create('word_scramble_games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category')->default('gaming'); // gaming, esports, games, streamers, characters
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('time_per_word')->default(30); // seconds per word
            $table->integer('words_per_game')->default(10); // number of words to solve
            $table->integer('hint_penalty')->default(5); // points deducted for using hint
            $table->integer('points_per_word')->default(10); // base points per word
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            
            $table->index('is_active');
        });

        Schema::create('word_scramble_words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_scramble_game_id')->constrained()->cascadeOnDelete();
            $table->string('word'); // The actual word
            $table->string('hint')->nullable(); // Optional hint
            $table->string('category'); // game, character, streamer, esports_team, etc.
            $table->integer('difficulty_level'); // 1-3 (easy, medium, hard based on word length/complexity)
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['word_scramble_game_id', 'difficulty_level']);
        });

        Schema::create('word_scramble_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('word_scramble_game_id')->constrained()->cascadeOnDelete();
            $table->integer('current_word_index')->default(0);
            $table->integer('total_score')->default(0);
            $table->integer('words_solved')->default(0);
            $table->integer('hints_used')->default(0);
            $table->json('solved_words')->nullable(); // Array of {word_id, time_taken, hints_used}
            $table->json('skipped_words')->nullable(); // Array of word_ids that were skipped
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'word_scramble_game_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_scramble_attempts');
        Schema::dropIfExists('word_scramble_words');
        Schema::dropIfExists('word_scramble_games');
    }
};
