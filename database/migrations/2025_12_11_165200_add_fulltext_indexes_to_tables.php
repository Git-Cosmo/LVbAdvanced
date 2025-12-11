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
        // Add full-text index on forum_threads (title only - content is in forum_posts)
        DB::statement('ALTER TABLE forum_threads ADD FULLTEXT ft_forum_threads_search (title)');
        
        // Note: forum_posts already has a fulltext index on content created in its migration
        
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
        DB::statement('ALTER TABLE news DROP INDEX ft_news_search');
    }
};
