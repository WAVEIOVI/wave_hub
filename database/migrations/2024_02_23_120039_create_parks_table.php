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
        Schema::create('parks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('park_client_id');
            $table->string('client_name')->nullable();
            $table->string('park_id');
            $table->string('park_type')->nullable();
            $table->string('park_title')->nullable();
            $table->text('park_address')->nullable();
            $table->string('park_postcode')->nullable();
            $table->string('park_city')->nullable();
            $table->string('park_country')->default('tunisia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parks');
    }
};
