<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add full-text index on forum_threads (title, content)
        DB::statement('ALTER TABLE forum_threads ADD FULLTEXT ft_forum_threads_search (title, content)');
        
        // Add full-text index on forum_posts (content)
        DB::statement('ALTER TABLE forum_posts ADD FULLTEXT ft_forum_posts_search (content)');
        
        // Add full-text index on news (title, excerpt, content)
        DB::statement('ALTER TABLE news ADD FULLTEXT ft_news_search (title, excerpt, content)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: Full-text indexes are dropped by dropping the index name
        DB::statement('ALTER TABLE forum_threads DROP INDEX ft_forum_threads_search');
        DB::statement('ALTER TABLE forum_posts DROP INDEX ft_forum_posts_search');
        DB::statement('ALTER TABLE news DROP INDEX ft_news_search');
    }
};
