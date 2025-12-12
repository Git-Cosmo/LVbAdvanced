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
        // Drop existing event-related tables
        Schema::dropIfExists('event_imported_items');
        Schema::dropIfExists('events');

        // Create main events table with all API fields
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Core event information from API
            $table->string('event_id')->unique(); // API event_id
            $table->string('name'); // Event name
            $table->string('slug')->unique(); // For URLs
            $table->text('link')->nullable(); // Original event link
            $table->text('description')->nullable();
            $table->string('language', 10)->nullable(); // e.g., "en"

            // Date and time information
            $table->string('date_human_readable')->nullable(); // e.g., "Fri, Feb 14, 10:00 – 11:30 PM PST"
            $table->dateTime('start_time')->nullable(); // Local time
            $table->dateTime('start_time_utc')->nullable(); // UTC time
            $table->integer('start_time_precision_sec')->nullable(); // Precision in seconds
            $table->dateTime('end_time')->nullable(); // Local time
            $table->dateTime('end_time_utc')->nullable(); // UTC time
            $table->integer('end_time_precision_sec')->nullable(); // Precision in seconds

            // Event format
            $table->boolean('is_virtual')->default(false);

            // Media
            $table->text('thumbnail')->nullable(); // Thumbnail URL

            // Publisher information
            $table->string('publisher')->nullable(); // e.g., "Spotify.com"
            $table->text('publisher_favicon')->nullable(); // Publisher favicon URL
            $table->string('publisher_domain')->nullable(); // e.g., "open.spotify.com"

            // Management fields
            $table->string('event_type')->default('general'); // tournament, release, expo, update, general
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('views_count')->default(0);

            $table->timestamps();

            // Indexes for better query performance
            $table->index('event_type');
            $table->index('start_time');
            $table->index('start_time_utc');
            $table->index('is_published');
            $table->index('is_virtual');
            $table->index('event_id'); // For deduplication
        });

        // Create venues table (normalized to avoid duplication)
        Schema::create('event_venues', function (Blueprint $table) {
            $table->id();

            // Venue identification
            $table->string('google_id')->unique()->nullable(); // Google Place ID
            $table->string('name'); // Venue name
            $table->string('phone_number')->nullable();
            $table->text('website')->nullable();

            // Ratings
            $table->integer('review_count')->nullable();
            $table->decimal('rating', 3, 1)->nullable(); // e.g., 4.5

            // Venue types
            $table->string('subtype')->nullable(); // Primary subtype
            $table->json('subtypes')->nullable(); // All subtypes as JSON array

            // Address information
            $table->text('full_address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('district')->nullable();
            $table->string('street_number')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('state')->nullable();
            $table->string('country', 10)->nullable(); // e.g., "US"
            $table->string('timezone')->nullable(); // e.g., "America/Los_Angeles"
            $table->string('google_mid')->nullable(); // Google MID

            $table->timestamps();

            // Indexes
            $table->index('city');
            $table->index('state');
            $table->index('country');
            $table->index(['latitude', 'longitude']);
        });

        // Create pivot table for events and venues (many-to-many relationship)
        Schema::create('event_venue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('venue_id')->constrained('event_venues')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['event_id', 'venue_id']);
        });

        // Create ticket links table
        Schema::create('event_ticket_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('source'); // e.g., "Spotify.com"
            $table->text('link'); // Ticket purchase link
            $table->text('fav_icon')->nullable(); // Source favicon URL
            $table->timestamps();

            $table->index('event_id');
        });

        // Create info links table
        Schema::create('event_info_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('source'); // e.g., "Nobhillgazette.com"
            $table->text('link'); // Information link
            $table->timestamps();

            $table->index('event_id');
        });

        // Create event_imported_items table for tracking imports
        Schema::create('event_imported_items', function (Blueprint $table) {
            $table->id();
            $table->string('source'); // Source identifier (e.g., "openwebninja")
            $table->string('external_id'); // External unique identifier (event_id from API)
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['source', 'external_id']); // Prevent duplicate imports
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_imported_items');
        Schema::dropIfExists('event_info_links');
        Schema::dropIfExists('event_ticket_links');
        Schema::dropIfExists('event_venue');
        Schema::dropIfExists('event_venues');
        Schema::dropIfExists('events');
    }
};
