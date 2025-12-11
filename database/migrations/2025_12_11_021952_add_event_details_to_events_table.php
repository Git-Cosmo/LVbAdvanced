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
        Schema::table('events', function (Blueprint $table) {
            $table->string('venue')->nullable()->after('location'); // Venue name
            $table->string('city')->nullable()->after('venue'); // City
            $table->string('country')->nullable()->after('city'); // Country
            $table->text('ticket_url')->nullable()->after('source_url'); // URL to purchase tickets
            $table->text('ticket_info')->nullable()->after('ticket_url'); // Ticket pricing and availability info
            $table->string('organizer')->nullable()->after('source'); // Event organizer
            $table->text('tags')->nullable()->after('platform'); // Additional tags/categories
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['venue', 'city', 'country', 'ticket_url', 'ticket_info', 'organizer', 'tags']);
        });
    }
};
