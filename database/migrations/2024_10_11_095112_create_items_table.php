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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('shortcode');
            $table->string('name');
            $table->string('picture')->default('empty.png');
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('category');
            $table->double('cost');
            $table->double('price');
            $table->integer('discount')->default(0);
            $table->boolean('status')->default(true);
            $table->string('quickorder_status')->default('true');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
