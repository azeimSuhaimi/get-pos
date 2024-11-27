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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->string('id_cust');
            $table->string('invoice_id');
            $table->string('shortcode');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->double('cost');
            $table->double('price');
            $table->string('user_email');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
