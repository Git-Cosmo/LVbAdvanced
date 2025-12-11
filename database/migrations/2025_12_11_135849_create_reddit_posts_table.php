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
        Schema::create('reddit_posts', function (Blueprint $table) {
            $table->id();
            $table->string('reddit_id')->unique(); // Reddit post ID for deduplication
            $table->string('subreddit', 50)->index(); // r/LivestreamFail or r/AITAH
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body')->nullable(); // Self text for AITAH posts
            $table->string('author')->nullable();
            $table->string('flair')->nullable();
            $table->string('url')->nullable(); // Post URL
            $table->string('permalink')->nullable(); // Reddit permalink
            $table->integer('score')->default(0);
            $table->integer('num_comments')->default(0);
            $table->timestamp('posted_at')->nullable(); // Original Reddit post time
            
            // Media fields
            $table->text('thumbnail')->nullable();
            $table->json('media')->nullable(); // Store video/image URLs and metadata
            $table->string('post_hint')->nullable(); // image, video, link, self
            $table->boolean('is_video')->default(false);
            $table->boolean('is_self')->default(false); // Text post
            
            // Management fields
            $table->boolean('is_published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('posted_at');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reddit_posts');
    }
};
