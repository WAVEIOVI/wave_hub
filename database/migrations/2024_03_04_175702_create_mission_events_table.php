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
        Schema::create('mission_events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Untitled Event'); // Add default value
            $table->string('mission_id')->nullable; // Add default value
            $table->string('mission_frequency')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->boolean('all_day')->default(true); // Assuming events are all-day by default
            $table->json('extendedProps')->nullable();
            $table->string('client')->nullable();
            $table->string('city')->nullable();
            $table->string('mission_type')->nullable();
            $table->string('calendar')->nullable();  // prevision ; pending ; completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_events');
    }
};
