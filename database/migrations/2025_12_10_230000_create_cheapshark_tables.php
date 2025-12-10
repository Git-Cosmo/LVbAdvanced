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
        Schema::create('cheap_shark_stores', function (Blueprint $table) {
            $table->id();
            $table->string('cheapshark_id')->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->string('logo')->nullable();
            $table->timestamps();
        });

        Schema::create('cheap_shark_games', function (Blueprint $table) {
            $table->id();
            $table->string('cheapshark_id')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->decimal('cheapest_price', 8, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('cheap_shark_deals', function (Blueprint $table) {
            $table->id();
            $table->string('deal_id')->unique();
            $table->foreignId('store_id')->constrained('cheap_shark_stores')->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('cheap_shark_games')->cascadeOnDelete();
            $table->decimal('sale_price', 8, 2);
            $table->decimal('normal_price', 8, 2);
            $table->decimal('savings', 6, 2)->nullable();
            $table->string('deal_rating')->nullable();
            $table->string('steam_app_id')->nullable();
            $table->boolean('on_sale')->default(true);
            $table->string('deal_link')->nullable();
            $table->timestamps();

            $table->index(['store_id', 'game_id']);
        });

        Schema::create('cheap_shark_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('run_type')->default('manual');
            $table->unsignedInteger('stores_synced')->default(0);
            $table->unsignedInteger('games_synced')->default(0);
            $table->unsignedInteger('deals_synced')->default(0);
            $table->text('message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheap_shark_sync_logs');
        Schema::dropIfExists('cheap_shark_deals');
        Schema::dropIfExists('cheap_shark_games');
        Schema::dropIfExists('cheap_shark_stores');
    }
};
