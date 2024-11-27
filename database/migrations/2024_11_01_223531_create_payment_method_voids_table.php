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
        Schema::create('payment_method_voids', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('payment_type');
            $table->double('tender')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('user_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_voids');
    }
};
