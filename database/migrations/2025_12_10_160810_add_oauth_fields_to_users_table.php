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
        Schema::table('users', function (Blueprint $table) {
            $table->string('steam_id')->nullable()->unique()->after('remember_token');
            $table->string('discord_id')->nullable()->unique()->after('steam_id');
            $table->string('battlenet_id')->nullable()->unique()->after('discord_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['steam_id', 'discord_id', 'battlenet_id']);
        });
    }
};
