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
            $table->double('subtotal');
            $table->double('tax');
            $table->double('total');
            $table->string('name')->nullable();
            $table->integer('daily_unique_number')->default(0);
            $table->string('name_cust')->nullable();
            $table->string('phone_cust')->nullable();
            $table->string('email_cust')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
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
