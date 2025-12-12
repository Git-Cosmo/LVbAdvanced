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
        Schema::create('profile_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_user_id')->constrained('users')->onDelete('cascade'); // Whose profile
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // Who posted
            $table->text('content');
            $table->boolean('is_approved')->default(true);
            $table->integer('reactions_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['profile_user_id', 'created_at']);
            $table->index('author_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_posts');
    }
};
