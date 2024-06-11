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
        Schema::create('su_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('su_address_id');
            $table->string('su_address_title')->nullable();
            $table->text('su_address_description')->nullable();
            $table->string('su_address_postcode')->nullable();
            $table->string('su_address_city')->nullable();
            $table->string('su_address_country')->default('tunisia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('su_addresses');
    }
};
