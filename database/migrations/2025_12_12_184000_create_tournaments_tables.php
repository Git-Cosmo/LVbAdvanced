<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Main tournaments table
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_server_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('game')->nullable();
            $table->enum('format', ['single_elimination', 'double_elimination', 'round_robin', 'swiss'])->default('single_elimination');
            $table->enum('type', ['solo', 'team'])->default('solo');
            $table->integer('team_size')->nullable();
            $table->integer('max_participants');
            $table->integer('current_participants')->default(0);
            $table->enum('status', ['upcoming', 'registration_open', 'registration_closed', 'in_progress', 'completed', 'cancelled'])->default('upcoming');
            $table->decimal('prize_pool', 10, 2)->nullable();
            $table->string('prize_currency')->default('USD');
            $table->json('prize_distribution')->nullable(); // e.g., {"1st": "50%", "2nd": "30%", "3rd": "20%"}
            $table->timestamp('registration_opens_at')->nullable();
            $table->timestamp('registration_closes_at')->nullable();
            $table->timestamp('check_in_starts_at')->nullable();
            $table->timestamp('check_in_ends_at')->nullable();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->json('rules')->nullable();
            $table->json('settings')->nullable(); // Additional tournament settings
            $table->boolean('is_public')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('requires_approval')->default(false);
            $table->string('cover_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'starts_at']);
            $table->index('slug');
        });

        // Tournament participants/teams
        Schema::create('tournament_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // For solo tournaments
            $table->foreignId('clan_id')->nullable()->constrained()->cascadeOnDelete(); // For team tournaments
            $table->string('team_name')->nullable();
            $table->integer('seed')->nullable(); // Seeding for brackets
            $table->enum('status', ['pending', 'approved', 'rejected', 'waitlist', 'checked_in', 'disqualified', 'eliminated'])->default('pending');
            $table->timestamp('registered_at');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->json('roster')->nullable(); // Team members if applicable
            $table->timestamps();

            $table->unique(['tournament_id', 'user_id']);
            $table->index(['tournament_id', 'status']);
        });

        // Tournament matches
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->integer('round'); // Round number
            $table->integer('match_number'); // Match number within round
            $table->foreignId('participant1_id')->nullable()->constrained('tournament_participants')->nullOnDelete();
            $table->foreignId('participant2_id')->nullable()->constrained('tournament_participants')->nullOnDelete();
            $table->foreignId('winner_id')->nullable()->constrained('tournament_participants')->nullOnDelete();
            $table->integer('participant1_score')->nullable();
            $table->integer('participant2_score')->nullable();
            $table->enum('status', ['pending', 'ready', 'in_progress', 'completed', 'disputed'])->default('pending');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('metadata')->nullable(); // Additional match data (map, server info, etc.)
            $table->timestamps();

            $table->index(['tournament_id', 'round']);
            $table->index(['tournament_id', 'status']);
        });

        // Tournament brackets (for visualization)
        Schema::create('tournament_brackets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->enum('bracket_type', ['winners', 'losers', 'finals'])->default('winners');
            $table->json('bracket_data'); // Stores the bracket structure
            $table->timestamps();

            $table->unique(['tournament_id', 'bracket_type']);
        });

        // Tournament check-ins
        Schema::create('tournament_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->constrained('tournament_participants')->cascadeOnDelete();
            $table->timestamp('checked_in_at');
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->unique(['tournament_id', 'participant_id']);
        });

        // Tournament announcements/chat
        Schema::create('tournament_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('message');
            $table->boolean('is_official')->default(false); // From organizers
            $table->timestamps();

            $table->index(['tournament_id', 'created_at']);
        });

        // Tournament staff/moderators
        Schema::create('tournament_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['organizer', 'moderator', 'referee'])->default('moderator');
            $table->timestamps();

            $table->unique(['tournament_id', 'user_id']);
        });

        // Match disputes
        Schema::create('tournament_disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('tournament_matches')->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('tournament_participants')->cascadeOnDelete();
            $table->text('reason');
            $table->text('evidence')->nullable();
            $table->enum('status', ['open', 'under_review', 'resolved', 'rejected'])->default('open');
            $table->text('resolution')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['match_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_disputes');
        Schema::dropIfExists('tournament_staff');
        Schema::dropIfExists('tournament_announcements');
        Schema::dropIfExists('tournament_check_ins');
        Schema::dropIfExists('tournament_brackets');
        Schema::dropIfExists('tournament_matches');
        Schema::dropIfExists('tournament_participants');
        Schema::dropIfExists('tournaments');
    }
};
