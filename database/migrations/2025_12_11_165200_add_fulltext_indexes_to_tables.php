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
        DB::statement('ALTER TABLE forum_threads ADD FULLTEXT search_index (title, content)');
        
        // Add full-text index on forum_posts (content)
        DB::statement('ALTER TABLE forum_posts ADD FULLTEXT search_index (content)');
        
        // Add full-text index on news (title, excerpt, content)
        DB::statement('ALTER TABLE news ADD FULLTEXT search_index (title, excerpt, content)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: Full-text indexes are dropped by dropping the index name
        DB::statement('ALTER TABLE forum_threads DROP INDEX search_index');
        DB::statement('ALTER TABLE forum_posts DROP INDEX search_index');
        DB::statement('ALTER TABLE news DROP INDEX search_index');
    }
};
