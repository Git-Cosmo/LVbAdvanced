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
        // Who Wants To Be A Millionaire Game
        Schema::create('millionaire_games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category')->default('general'); // e.g., gaming, sports, general
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('time_limit')->default(60); // seconds per question
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            
            $table->index('is_active');
        });

        Schema::create('millionaire_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('millionaire_game_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->json('options'); // 4 answer options
            $table->integer('correct_answer_index'); // 0-3
            $table->integer('difficulty_level'); // Question level (1-15)
            $table->integer('prize_amount'); // Prize for this question
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['millionaire_game_id', 'difficulty_level']);
        });

        Schema::create('millionaire_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('millionaire_game_id')->constrained()->cascadeOnDelete();
            $table->integer('current_question')->default(1); // 1-15
            $table->integer('prize_won')->default(0);
            $table->json('lifelines_used')->nullable(); // ['fifty_fifty', 'phone_friend', 'ask_audience']
            $table->json('answers')->nullable(); // User's answers history
            $table->enum('status', ['in_progress', 'completed', 'walked_away', 'failed'])->default('in_progress');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'millionaire_game_id']);
            $table->index('status');
        });

        // GeoGuessr-style Game
        Schema::create('geoguessr_games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('rounds')->default(5); // Number of rounds per game
            $table->integer('time_per_round')->default(120); // seconds
            $table->integer('max_points_per_round')->default(5000);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            
            $table->index('is_active');
        });

        Schema::create('geoguessr_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('geoguessr_game_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Location name (optional, for hints)
            $table->string('country');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('image_url'); // URL to location image
            $table->text('hint')->nullable();
            $table->integer('difficulty_rating')->default(3); // 1-5
            $table->timestamps();

            $table->index(['geoguessr_game_id']);
        });

        Schema::create('geoguessr_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('geoguessr_game_id')->constrained()->cascadeOnDelete();
            $table->integer('total_score')->default(0);
            $table->integer('rounds_completed')->default(0);
            $table->json('round_data')->nullable(); // Detailed data per round
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'geoguessr_game_id']);
            $table->index('status');
        });

        // Multiplayer Rooms for both games
        Schema::create('game_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // 6-digit room code
            $table->string('game_type'); // 'millionaire', 'geoguessr', 'trivia'
            $table->unsignedBigInteger('game_id'); // ID of the game
            $table->foreignId('host_user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('max_players')->default(10);
            $table->enum('status', ['waiting', 'in_progress', 'completed', 'cancelled'])->default('waiting');
            $table->json('settings')->nullable(); // Room-specific settings
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['code', 'status']);
        });

        Schema::create('game_room_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('score')->default(0);
            $table->integer('rank')->nullable();
            $table->enum('status', ['waiting', 'ready', 'playing', 'finished', 'left'])->default('waiting');
            $table->timestamp('joined_at');
            $table->timestamps();

            $table->unique(['game_room_id', 'user_id']);
        });

        // Streamers tracking
        Schema::create('streamers', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // 'twitch' or 'kick'
            $table->string('username')->unique();
            $table->string('display_name');
            $table->string('profile_image_url')->nullable();
            $table->string('channel_url');
            $table->boolean('is_live')->default(false);
            $table->integer('viewer_count')->default(0);
            $table->string('stream_title')->nullable();
            $table->string('game_name')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->timestamp('stream_started_at')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();

            $table->index(['platform', 'is_live', 'viewer_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streamers');
        Schema::dropIfExists('game_room_players');
        Schema::dropIfExists('game_rooms');
        Schema::dropIfExists('geoguessr_attempts');
        Schema::dropIfExists('geoguessr_locations');
        Schema::dropIfExists('geoguessr_games');
        Schema::dropIfExists('millionaire_attempts');
        Schema::dropIfExists('millionaire_questions');
        Schema::dropIfExists('millionaire_games');
    }
};
