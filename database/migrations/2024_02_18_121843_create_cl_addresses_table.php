<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cl_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('cl_address_id');
            $table->string('cl_address_title')->nullable();
            $table->text('cl_address_description')->nullable();
            $table->string('cl_address_postcode')->nullable();
            $table->string('cl_address_city')->nullable();
            $table->string('cl_address_country')->default('tunisia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cl_addresses');
    }
};
