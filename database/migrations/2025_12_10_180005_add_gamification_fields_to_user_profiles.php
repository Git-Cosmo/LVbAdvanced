<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->unsignedInteger('login_streak')->default(0)->after('karma');
            $table->unsignedInteger('posting_streak')->default(0)->after('login_streak');
            $table->timestamp('last_login_at')->nullable()->after('posting_streak');
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['login_streak', 'posting_streak', 'last_login_at']);
        });
    }
};
