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
        Schema::create('forum_polls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('forum_threads')->onDelete('cascade');
            $table->string('question');
            $table->boolean('is_multiple_choice')->default(false);
            $table->boolean('is_public')->default(false);
            $table->timestamp('closes_at')->nullable();
            $table->integer('total_votes')->default(0);
            $table->timestamps();

            $table->unique('thread_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_polls');
    }
};
