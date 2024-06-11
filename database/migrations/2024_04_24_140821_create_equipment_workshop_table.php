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
        Schema::create('equipment_workshop', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->foreignId('workshop_id')->constrained()->onDelete('cascade');
            $table->string('inspection')->nullable();
            $table->string('raw_recharge')->nullable();
            $table->string('nitrogen_recharge')->nullable();
            $table->string('maintenance')->nullable();
            $table->string('additional_maintenance')->nullable();
            $table->string('supply')->nullable();
            $table->string('standard_sign')->nullable();
            $table->string('numbering')->nullable();
            $table->string('pictogram')->nullable();
            $table->string('equipment_fixation')->nullable();
            $table->string('accessories')->nullable();
            $table->string('equipment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_workshop');
    }
};
