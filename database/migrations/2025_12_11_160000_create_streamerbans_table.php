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
        Schema::create('streamer_bans', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('slug')->unique();
            $table->string('profile_url')->nullable();
            $table->string('avatar_url')->nullable();
            
            // Ban statistics
            $table->integer('total_bans')->default(0);
            $table->string('last_ban')->nullable();
            $table->string('longest_ban')->nullable();
            
            // Ban history (stored as JSON array)
            $table->json('ban_history')->nullable();
            
            // Metadata
            $table->timestamp('last_scraped_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('username');
            $table->index('total_bans');
            $table->index('is_published');
            $table->index('last_scraped_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streamer_bans');
    }
};
