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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('client_name')->unique();
            $table->string('client_website')->nullable();
            $table->string('main_phone_number')->nullable();
            $table->string('client_email')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable(); //
            $table->string('city')->nullable(); //
            $table->string('country')->default('tunisia'); //
            $table->string('client_type')->nullable();
            $table->string('client_activity')->nullable();
            $table->string('client_status')->default('pending');
            $table->string('tax_id')->nullable();
            $table->string('rne_id')->nullable();
            $table->boolean('has_vat_exemption_cert')->default(false);
            $table->string('vat_exemption_cert_id')->nullable();
            $table->date('vat_exemption_start')->nullable();
            $table->date('vat_exemption_end')->nullable();
            $table->string('company_form_legal')->nullable();
            $table->string('company_capital')->nullable();
            $table->date('created_date')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_agency')->nullable();
            $table->string('bank_rib')->nullable();
            $table->string('payment_terms')->nullable();
            $table->text('client_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
