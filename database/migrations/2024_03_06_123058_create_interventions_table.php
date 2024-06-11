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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_folder_id')->constrained()->cascadeOnDelete();
            $table->string('intervention_id')->nullable();
            $table->date('intervention_date')->nullable();
            $table->string('mission_frequency')->nullable();
            $table->string('intervention_duration')->nullable();
            $table->enum('intervention_status', ['pending', 'in_progress', 'completed'])->default('pending');

            $table->string('team_leader')->nullable();
            $table->string('team_driver')->nullable();
            $table->string('team_members')->nullable();
            $table->string('team_total')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('fuel_price_100km')->nullable();
            $table->string('target_in_km')->nullable();
            $table->string('fuel_transportation')->nullable();
            $table->string('accommodation_night')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('meals_cost_member_day')->nullable();
            $table->string('meals_food')->nullable();
            $table->string('miscellaneous_expenses')->nullable();
            $table->string('intervention_finance_total')->nullable();
            $table->text('intervention_notes')->nullable();

            // data client
            $table->string('mission_client_id')->nullable(); //
            $table->string('client_name')->nullable(); //
            $table->string('client_website')->nullable(); //
            $table->string('main_phone_number')->nullable(); //
            $table->string('client_email')->nullable(); //
            $table->string('address')->nullable(); //
            $table->string('postcode')->nullable(); //
            $table->string('city')->nullable(); //
            $table->string('country')->nullable(); //
            // data Park
            $table->string('park')->nullable(); //
            $table->string('park_id')->nullable(); //
            $table->string('park_type')->nullable(); //
            $table->string('park_title')->nullable(); //
            $table->text('park_address')->nullable(); //
            $table->string('park_postcode')->nullable(); //
            $table->string('park_city')->nullable(); //
            $table->string('park_country')->nullable(); //

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
        Schema::dropIfExists('interventions');
    }
};
