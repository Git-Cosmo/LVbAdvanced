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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('status')->default('online')->after('last_activity_at'); // online, away, busy, offline
            $table->string('status_message', 140)->nullable()->after('status'); // Custom status message
            $table->timestamp('status_updated_at')->nullable()->after('status_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['status', 'status_message', 'status_updated_at']);
        });
    }
};
