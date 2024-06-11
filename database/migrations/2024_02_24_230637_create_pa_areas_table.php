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
        Schema::create('pa_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('park_id')->constrained()->cascadeOnDelete();
            $table->string('area_id')->nullable();
            $table->string('area_description')->nullable();
            $table->string('area_accessibility')->nullable();
            $table->string('area_classification')->nullable();
            $table->string('qrc_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pa_areas');
    }
};
