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
        Schema::create('invoice_voids', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('user_email');
            $table->double('subtotal');
            $table->double('tax');
            $table->double('total');
            $table->string('name_cust')->nullable();
            $table->string('phone_cust')->nullable();
            $table->string('email_cust')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_voids');
    }
};
