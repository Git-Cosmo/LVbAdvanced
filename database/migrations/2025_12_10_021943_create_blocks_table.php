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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // LatestThreads, CustomHTML, etc.
            $table->string('title')->nullable();
            $table->boolean('show_title')->default(true);
            $table->text('content')->nullable(); // For CustomHTML blocks
            $table->json('config')->nullable(); // Block-specific configuration
            $table->integer('cache_lifetime')->default(0); // 0 = no cache, in minutes
            $table->string('template')->nullable(); // Override default template
            $table->string('visibility')->default('public'); // public, auth, guest, role-based
            $table->json('visibility_roles')->nullable(); // Array of role IDs if role-based
            $table->string('html_class')->nullable();
            $table->string('html_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
