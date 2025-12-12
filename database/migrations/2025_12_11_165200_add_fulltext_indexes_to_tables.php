<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only add FULLTEXT indexes for MySQL/MariaDB
        // SQLite doesn't support FULLTEXT indexes but has built-in FTS functionality
        if (DB::getDriverName() === 'mysql') {
            // Add full-text index on forum_threads (title only).
            // Note: The 'content' column is not included in this index because 'content' is stored in the forum_posts table, not in forum_threads.
            DB::statement('ALTER TABLE forum_threads ADD FULLTEXT ft_forum_threads_search (title)');

            // Note: forum_posts already has a fulltext index on content created in its migration

            // Add full-text index on news (title, excerpt, content)
            DB::statement('ALTER TABLE news ADD FULLTEXT ft_news_search (title, excerpt, content)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop FULLTEXT indexes for MySQL/MariaDB
        if (DB::getDriverName() === 'mysql') {
            // Note: Full-text indexes are dropped by dropping the index name
            DB::statement('ALTER TABLE forum_threads DROP INDEX ft_forum_threads_search');
            DB::statement('ALTER TABLE news DROP INDEX ft_news_search');
        }
    }
};
