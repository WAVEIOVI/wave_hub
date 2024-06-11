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
        Schema::create('equipment_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_category_id')->constrained()->cascadeOnDelete();
            $table->string('model_id')->unique();
            $table->string('model_category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('inspection')->nullable();
            $table->boolean('raw_recharge')->nullable();
            $table->boolean('nitrogen_recharge')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_models');
    }
};
