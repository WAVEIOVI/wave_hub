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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('park_id')->constrained()->cascadeOnDelete();
            $table->string('qrc_id')->nullable();
            $table->string('model_id')->nullable();
            $table->string('equipment_category_id')->nullable();
            $table->string('equipment_category')->nullable();
            $table->string('equipment_model_id')->nullable();
            $table->string('equipment_model')->nullable();
            $table->string('equipment_weight_unit')->nullable();
            $table->string('equipment_weight_value')->nullable();
            $table->string('equipment_pressure_id')->nullable();
            $table->string('equipment_pressure')->nullable();
            $table->string('equipment_protection_id')->nullable();
            $table->string('equipment_protection')->nullable();

            // $table->string('pictogram')->nullable();
            // $table->string('standard_sign')->nullable();
            // $table->string('numbering')->nullable();
            // $table->string('accessories_availability')->nullable();
            // $table->string('equipment_fixation')->nullable();

            $table->string('internal_id')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('mfg_date')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('equipment_brand')->nullable();
            $table->string('made_in')->nullable();
            $table->string('ce_marking')->nullable();

            $table->string('equipment_status')->nullable();

            $table->string('park_park_id')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_name')->nullable();

            $table->string('area_id')->nullable();
            $table->string('equipment_area')->nullable();
            $table->string('equipment_area_description')->nullable();
            $table->string('equipment_area_accessibility')->nullable();
            $table->string('equipment_area_classification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
