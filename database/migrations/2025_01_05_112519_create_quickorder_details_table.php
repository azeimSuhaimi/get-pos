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
        Schema::create('quickorder_details', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('shortcode');
            $table->string('name');
            $table->string('quantity');
            $table->double('price');
            $table->double('cost');
            $table->string('description')->nullable();
            $table->string('category');
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quickorder_details');
    }
};
