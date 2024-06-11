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
        Schema::create('mission_folders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('mission_id')->unique(); //
            $table->string('mission_type')->nullable(); //
            $table->date('mission_date')->nullable();
            $table->string('mission_duration')->nullable();
            $table->string('mission_frequency')->nullable();
            $table->enum('mission_status', ['pending', 'in_progress', 'completed', 'closure']);
            // Resources 
            $table->string('team_leader')->nullable();
            $table->string('team_driver')->nullable();
            $table->string('team_members')->nullable();
            $table->string('team_total')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('fuel_price_100km')->default('0');
            $table->string('target_in_km')->nullable();
            $table->string('fuel_transportation')->default('0');
            $table->string('accommodation_night')->default('0');
            $table->string('accommodation')->default('0');
            $table->string('meals_cost_member_day')->default('0');
            $table->string('meals_food')->default('0');
            $table->string('miscellaneous_expenses')->default('0');
            $table->string('mission_finance_total')->default('0');
            $table->text('mission_notes')->nullable();
            // data client
            $table->string('mission_client_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_website')->nullable();
            $table->string('main_phone_number')->nullable();
            $table->string('client_email')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            // data Park
            $table->string('park')->nullable();
            $table->string('park_id')->nullable();
            $table->string('park_type')->nullable();
            $table->string('park_title')->nullable();
            $table->text('park_address')->nullable();
            $table->string('park_postcode')->nullable();
            $table->string('park_city')->nullable();
            $table->string('park_country')->nullable();

            $table->string('total_equipment')->nullable();
            $table->string('total_fire_extinguisher')->nullable();
            $table->string('total_fire_hose')->nullable();
            $table->string('total_others_equipment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mission_folders');
    }
};
