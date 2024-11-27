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
        Schema::create('suspend_details', function (Blueprint $table) {
            $table->id();
            $table->string('bill_id');
            $table->string('shortcode');
            $table->string('name');
            $table->string('quantity');
            $table->double('price');
            $table->double('cost');
            $table->string('description')->nullable();
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspend_details');
    }
};
