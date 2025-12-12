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
        // Site Themes for seasonal/event-based visual effects
        Schema::create('site_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Christmas 2025", "New Year 2026"
            $table->string('slug')->unique(); // e.g., "christmas", "new-year", "easter"
            $table->text('description')->nullable();
            $table->json('effects')->nullable(); // JSON config for visual effects
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(false);
            $table->integer('priority')->default(0); // Higher priority themes override lower
            $table->timestamps();
        });

        // Trivia Games
        Schema::create('trivia_games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category'); // e.g., gaming, sports, general
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('time_limit')->default(30); // seconds per question
            $table->integer('points_per_correct')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('trivia_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trivia_game_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->json('options'); // Array of answer options
            $table->integer('correct_answer_index'); // Index of correct answer in options array
            $table->text('explanation')->nullable();
            $table->integer('points')->default(10);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('trivia_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trivia_game_id')->constrained()->cascadeOnDelete();
            $table->integer('score')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->integer('total_questions');
            $table->integer('time_taken')->nullable(); // seconds
            $table->json('answers')->nullable(); // User's answers
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'trivia_game_id']);
        });

        // Prediction Games
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category'); // tournament, match, esports, etc.
            $table->json('options'); // Array of prediction options
            $table->integer('correct_option_index')->nullable(); // Set after event concludes
            $table->integer('points_reward')->default(50); // Points for correct prediction
            $table->timestamp('closes_at'); // When predictions close
            $table->timestamp('resolves_at')->nullable(); // When result is known
            $table->enum('status', ['open', 'closed', 'resolved'])->default('open');
            $table->timestamps();
        });

        Schema::create('prediction_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prediction_id')->constrained()->cascadeOnDelete();
            $table->integer('selected_option_index');
            $table->integer('points_wagered')->default(0);
            $table->boolean('is_correct')->nullable();
            $table->integer('points_won')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'prediction_id']);
        });

        // Tournament Betting
        Schema::create('tournament_bets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tournament_participant_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('bet_type', ['winner', 'top_3', 'match_result'])->default('winner');
            $table->integer('points_wagered');
            $table->decimal('odds', 5, 2)->default(1.0);
            $table->enum('status', ['pending', 'won', 'lost', 'refunded'])->default('pending');
            $table->integer('points_won')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'tournament_id']);
            $table->index('status');
        });

        // Daily Challenges
        Schema::create('daily_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('challenge_type'); // e.g., posts, likes, views, achievements
            $table->json('requirements'); // What needs to be done
            $table->integer('points_reward')->default(25);
            $table->json('badge_reward')->nullable(); // Optional badge ID
            $table->date('valid_date'); // Which day this challenge is for
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('valid_date');
        });

        Schema::create('daily_challenge_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('daily_challenge_id')->constrained()->cascadeOnDelete();
            $table->integer('points_earned');
            $table->json('completion_data')->nullable(); // Progress data
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->unique(['user_id', 'daily_challenge_id']);
            $table->index(['user_id', 'completed_at']);
        });

        // User Points Ledger for tracking points from games
        Schema::create('user_points_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('source_type'); // trivia, prediction, bet, challenge
            $table->unsignedBigInteger('source_id');
            $table->integer('points_change'); // Positive or negative
            $table->integer('balance_after');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['source_type', 'source_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_points_ledger');
        Schema::dropIfExists('daily_challenge_completions');
        Schema::dropIfExists('daily_challenges');
        Schema::dropIfExists('tournament_bets');
        Schema::dropIfExists('prediction_entries');
        Schema::dropIfExists('predictions');
        Schema::dropIfExists('trivia_attempts');
        Schema::dropIfExists('trivia_questions');
        Schema::dropIfExists('trivia_games');
        Schema::dropIfExists('site_themes');
    }
};
