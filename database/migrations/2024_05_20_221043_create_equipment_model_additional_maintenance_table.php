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
        Schema::create('equipment_model_additional_maintenance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipment_model_id')
                ->constrained()
                ->onDelete('cascade')
                ->name('fk_equip_model_add_maint_equip_model'); // Shortened constraint name

            $table->foreignId('additional_maintenance_id')
                ->constrained()
                ->onDelete('cascade')
                ->name('fk_equip_model_add_maint_add_maint'); // Shortened constraint name

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_model_additional_maintenance');
    }
};
