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
        Schema::create('customeritemredeens', function (Blueprint $table) {
            $table->id();
            $table->string('id_customer');
            $table->string('name_item');
            $table->text('description_item')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('ic')->nullable();
            $table->string('point');
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
        Schema::dropIfExists('customeritemredeens');
    }
};
