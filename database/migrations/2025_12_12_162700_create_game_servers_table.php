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
        Schema::create('game_servers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Server name (e.g., "FiveM Server", "CS2 Server")
            $table->string('game'); // Game type (e.g., "GTA V", "Counter Strike 2")
            $table->string('game_short_code', 10); // Short code (e.g., "5M", "CS2", "MC")
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->integer('port')->nullable();
            $table->string('connect_url')->nullable(); // Direct connect URL
            $table->enum('status', ['online', 'offline', 'maintenance', 'coming_soon'])->default('coming_soon');
            $table->integer('max_players')->nullable();
            $table->integer('current_players')->default(0);
            $table->string('map')->nullable(); // Current map
            $table->string('game_mode')->nullable(); // Game mode (e.g., "RP", "Competitive", "Survival")
            $table->json('metadata')->nullable(); // Additional server info
            $table->string('icon_color_from')->default('#8B5CF6'); // Gradient start color
            $table->string('icon_color_to')->default('#EC4899'); // Gradient end color
            $table->integer('display_order')->default(0); // Sort order
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_ping_at')->nullable(); // Last status check
            $table->timestamps();
            
            $table->index('game');
            $table->index('status');
            $table->index(['is_active', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_servers');
    }
};
