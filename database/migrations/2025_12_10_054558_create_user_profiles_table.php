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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('about_me')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('steam_id')->nullable();
            $table->string('discord_id')->nullable();
            $table->string('battlenet_id')->nullable();
            $table->string('xbox_gamertag')->nullable();
            $table->string('psn_id')->nullable();
            $table->integer('xp')->default(0);
            $table->integer('level')->default(1);
            $table->integer('karma')->default(0);
            $table->string('user_title')->nullable();
            $table->json('custom_fields')->nullable();
            $table->json('privacy_settings')->nullable();
            $table->integer('followers_count')->default(0);
            $table->integer('following_count')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
            $table->index('xp');
            $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
