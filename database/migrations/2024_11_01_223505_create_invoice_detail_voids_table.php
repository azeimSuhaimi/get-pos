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
        Schema::create('invoice_detail_voids', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('shortcode');
            $table->string('name');
            $table->string('quantity');
            $table->double('price');
            $table->double('cost');
            $table->string('description')->nullable();
            $table->string('category');
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('invoice_detail_voids');
    }
};
