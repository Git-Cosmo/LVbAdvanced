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
        Schema::create('forum_poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained('forum_polls')->onDelete('cascade');
            $table->string('option_text');
            $table->integer('votes_count')->default(0);
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['poll_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_poll_options');
    }
};
