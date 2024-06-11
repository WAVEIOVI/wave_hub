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
        Schema::create('in_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_intervention_id')->constrained('equipment_intervention')->onDelete('cascade');
            $table->string('maintenance_id')->unique();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_maintenances');
    }
};
