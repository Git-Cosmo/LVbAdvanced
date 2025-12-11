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
        Schema::create('reddit_subreddits', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique(); // Subreddit name (e.g., 'LivestreamFail')
            $table->string('display_name', 100); // Display name for admin
            $table->boolean('is_enabled')->default(true);
            $table->string('content_type', 20)->default('mixed'); // video, text, mixed
            $table->integer('scrape_limit')->default(25); // How many posts to fetch per scrape
            $table->timestamp('last_scraped_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reddit_subreddits');
    }
};
