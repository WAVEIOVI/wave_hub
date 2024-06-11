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
        Schema::create('in_check_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained()->cascadeOnDelete();
            $table->string('mission_documents')->default('false');
            $table->string('team_documents')->default('false');
            $table->string('ppe')->default('false');
            $table->string('emergency_kit')->default('false');
            $table->string('vehicle_maintenance')->default('false');
            $table->string('materials_and_parts')->default('false');
            $table->string('tools_and_equipment')->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_check_lists');
    }
};
