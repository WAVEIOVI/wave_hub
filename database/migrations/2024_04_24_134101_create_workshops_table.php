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
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_folder_id')->constrained()->cascadeOnDelete();
            $table->string('workshop_id')->nullable();
            $table->date('workshop_date')->nullable();
            $table->string('mission_frequency')->nullable();
            $table->string('workshop_duration')->nullable();
            $table->enum('workshop_status', ['pending', 'in_progress', 'completed'])->default('pending');

            $table->string('workshop_leader')->nullable();
            $table->string('team_members')->nullable();
            $table->text('workshop_notes')->nullable();
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
        Schema::dropIfExists('workshops');
    }
};
