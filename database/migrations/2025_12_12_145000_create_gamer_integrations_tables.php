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
        // Game integrations (Steam/Xbox/PSN sync)
        Schema::create('game_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform'); // steam, xbox, psn
            $table->string('platform_id'); // Platform-specific user ID
            $table->string('username')->nullable();
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->json('metadata')->nullable(); // Additional platform-specific data
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'platform']);
            $table->index('platform');
            $table->index('is_active');
        });

        // Game libraries
        Schema::create('game_libraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('integration_id')->constrained('game_integrations')->onDelete('cascade');
            $table->string('game_id'); // Platform-specific game ID
            $table->string('game_name');
            $table->string('platform');
            $table->string('image_url')->nullable();
            $table->integer('playtime_minutes')->default(0); // Total playtime
            $table->timestamp('added_at')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('platform');
            $table->index(['user_id', 'platform']);
        });

        // Recently played games
        Schema::create('recently_played', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_library_id')->constrained()->onDelete('cascade');
            $table->timestamp('last_played_at');
            $table->integer('session_minutes')->default(0); // Last session duration
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('last_played_at');
            $table->index(['user_id', 'last_played_at']);
        });

        // Player stats
        Schema::create('player_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_library_id')->constrained()->onDelete('cascade');
            $table->string('stat_name'); // e.g., 'kills', 'wins', 'level'
            $table->string('stat_value');
            $table->string('stat_type')->default('integer'); // integer, float, string, json
            $table->timestamp('recorded_at');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index(['game_library_id', 'stat_name']);
        });

        // Clans/Guilds
        Schema::create('clans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag', 10)->unique(); // Clan tag (e.g., [CLAN])
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('game')->nullable(); // Primary game
            $table->string('logo_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_recruiting')->default(true);
            $table->integer('member_limit')->default(50);
            $table->json('requirements')->nullable(); // Join requirements
            $table->timestamps();
            
            $table->index('slug');
            $table->index('game');
            $table->index(['is_public', 'is_recruiting']);
        });

        // Clan members
        Schema::create('clan_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['member', 'officer', 'leader'])->default('member');
            $table->timestamp('joined_at');
            $table->json('stats')->nullable(); // Member-specific clan stats
            $table->timestamps();
            
            $table->unique(['clan_id', 'user_id']);
            $table->index('clan_id');
            $table->index('user_id');
        });

        // Clan forums/discussions
        Schema::create('clan_forums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->index('clan_id');
            $table->index(['clan_id', 'is_pinned']);
        });

        // Clan events/calendar
        Schema::create('clan_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('event_type'); // raid, pvp, tournament, meeting, etc.
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->integer('max_participants')->nullable();
            $table->json('participants')->nullable(); // Array of user IDs
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('clan_id');
            $table->index('start_time');
            $table->index(['clan_id', 'start_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clan_events');
        Schema::dropIfExists('clan_forums');
        Schema::dropIfExists('clan_members');
        Schema::dropIfExists('clans');
        Schema::dropIfExists('player_stats');
        Schema::dropIfExists('recently_played');
        Schema::dropIfExists('game_libraries');
        Schema::dropIfExists('game_integrations');
    }
};
