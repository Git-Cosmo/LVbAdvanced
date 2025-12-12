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
        Schema::create('rss_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->boolean('is_active')->default(true);
            $table->integer('refresh_interval')->default(60); // minutes
            $table->timestamp('last_fetched_at')->nullable();
            $table->json('settings')->nullable(); // for custom mapping rules
            $table->timestamps();
        });

        // Track imported news items to avoid duplicates
        Schema::create('rss_imported_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rss_feed_id')->constrained()->onDelete('cascade');
            $table->string('guid')->unique(); // RSS item guid
            $table->foreignId('news_id')->nullable()->constrained('news')->onDelete('set null');
            $table->timestamps();

            $table->index(['rss_feed_id', 'guid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rss_imported_items');
        Schema::dropIfExists('rss_feeds');
    }
};
