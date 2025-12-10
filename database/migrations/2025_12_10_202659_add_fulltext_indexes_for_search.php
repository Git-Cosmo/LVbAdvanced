<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add fulltext index to forum_threads table
        Schema::table('forum_threads', function (Blueprint $table) {
            DB::statement('ALTER TABLE forum_threads ADD FULLTEXT fulltext_search (title, content)');
        });

        // Add fulltext index to forum_posts table
        Schema::table('forum_posts', function (Blueprint $table) {
            DB::statement('ALTER TABLE forum_posts ADD FULLTEXT fulltext_search (content)');
        });

        // Add fulltext index to news table
        Schema::table('news', function (Blueprint $table) {
            DB::statement('ALTER TABLE news ADD FULLTEXT fulltext_search (title, excerpt, content)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            DB::statement('ALTER TABLE forum_threads DROP INDEX fulltext_search');
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            DB::statement('ALTER TABLE forum_posts DROP INDEX fulltext_search');
        });

        Schema::table('news', function (Blueprint $table) {
            DB::statement('ALTER TABLE news DROP INDEX fulltext_search');
        });
    }
};
