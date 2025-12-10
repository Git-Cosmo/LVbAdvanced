<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('path');
            $table->string('url');
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('size');
            $table->string('mime');
            $table->string('name');
            $table->string('type')->nullable(); // image, video, audio, resource
            $table->string('game')->nullable();
            $table->unsignedInteger('downloads')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_media');
    }
};
