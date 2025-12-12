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
        Schema::create('patch_notes', function (Blueprint $table) {
            $table->id();
            $table->string('game_name'); // e.g., 'Counter Strike 2', 'GTA V'
            $table->string('version')->nullable(); // e.g., '1.2.3', 'Season 5'
            $table->string('title'); // Patch title
            $table->string('slug')->unique(); // URL-friendly slug
            $table->text('description')->nullable(); // Brief description
            $table->longText('content'); // Full patch notes content
            $table->string('source_url')->nullable(); // Original source URL
            $table->string('external_id')->nullable(); // External API ID for deduplication
            $table->timestamp('released_at')->nullable(); // When the patch was released
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();

            // Indexes for performance
            $table->index('game_name');
            $table->index('released_at');
            $table->index('is_published');
            $table->index(['game_name', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patch_notes');
    }
};
