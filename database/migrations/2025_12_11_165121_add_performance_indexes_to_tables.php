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
        // Forum threads indexes
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->index(['forum_id', 'is_hidden', 'last_post_at'], 'idx_forum_threads_performance');
            $table->index(['user_id', 'created_at'], 'idx_forum_threads_user');
            $table->index(['is_pinned', 'is_hidden'], 'idx_forum_threads_display');
        });

        // Forum posts indexes
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->index(['thread_id', 'created_at'], 'idx_forum_posts_thread');
            $table->index(['user_id', 'created_at'], 'idx_forum_posts_user');
        });

        // News indexes
        Schema::table('news', function (Blueprint $table) {
            $table->index(['is_published', 'published_at'], 'idx_news_published');
            $table->index(['is_featured', 'published_at'], 'idx_news_featured');
        });

        // Downloads indexes
        Schema::table('galleries', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_galleries_user');
            $table->index(['is_approved', 'created_at'], 'idx_galleries_approved');
            $table->index(['is_featured', 'created_at'], 'idx_galleries_featured');
        });

        // User profiles indexes
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->index('xp', 'idx_user_profiles_xp');
            $table->index('karma', 'idx_user_profiles_karma');
            $table->index('level', 'idx_user_profiles_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropIndex('idx_forum_threads_performance');
            $table->dropIndex('idx_forum_threads_user');
            $table->dropIndex('idx_forum_threads_display');
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropIndex('idx_forum_posts_thread');
            $table->dropIndex('idx_forum_posts_user');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('idx_news_published');
            $table->dropIndex('idx_news_featured');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex('idx_galleries_user');
            $table->dropIndex('idx_galleries_approved');
            $table->dropIndex('idx_galleries_featured');
        });

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropIndex('idx_user_profiles_xp');
            $table->dropIndex('idx_user_profiles_karma');
            $table->dropIndex('idx_user_profiles_level');
        });
    }
};
