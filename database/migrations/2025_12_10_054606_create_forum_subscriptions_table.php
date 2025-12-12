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
        Schema::create('forum_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->morphs('subscribable'); // Can be thread or forum
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_push')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'subscribable_id', 'subscribable_type'], 'unique_subscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_subscriptions');
    }
};
