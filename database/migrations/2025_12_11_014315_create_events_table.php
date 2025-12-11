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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('source')->nullable(); // Source name (e.g., "RAWG API", "GamesIndustry.biz RSS")
            $table->string('source_url')->nullable(); // Original event URL
            $table->string('external_id')->nullable(); // External API ID for deduplication
            $table->string('event_type')->default('general'); // tournament, release, expo, update, general
            $table->string('game_name')->nullable(); // Related game if applicable
            $table->dateTime('start_date')->nullable(); // Event start date
            $table->dateTime('end_date')->nullable(); // Event end date
            $table->string('location')->nullable(); // Physical or online location
            $table->string('platform')->nullable(); // Gaming platform (PC, PS5, Xbox, etc.)
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('event_type');
            $table->index('start_date');
            $table->index('is_published');
            $table->index(['source', 'external_id']); // For deduplication
        });

        // Create event_imported_items table for tracking scraped data
        Schema::create('event_imported_items', function (Blueprint $table) {
            $table->id();
            $table->string('source'); // Source identifier
            $table->string('external_id'); // External unique identifier
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['source', 'external_id']); // Prevent duplicate imports
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_imported_items');
        Schema::dropIfExists('events');
    }
};
