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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_id');
            $table->string('supplier_name');
            $table->string('main_phone_number')->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('supplier_website')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('tunisia');
            $table->string('supplier_type')->nullable();
            $table->string('supplier_activity')->nullable();
            $table->string('supplier_status')->default('pending');
            $table->string('tax_id')->nullable();
            $table->string('rne_id')->nullable();
            $table->string('company_form_legal')->nullable();
            $table->string('company_capital')->nullable();
            $table->date('created_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_agency')->nullable();
            $table->string('bank_rib')->nullable();
            $table->string('payment_terms')->nullable();
            $table->text('supplier_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
