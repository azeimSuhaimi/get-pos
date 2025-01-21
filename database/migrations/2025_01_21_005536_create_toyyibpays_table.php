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
        Schema::create('toyyibpays', function (Blueprint $table) {
            $table->id();
            $table->text('toyyip_key')->nullable();
            $table->text('toyyip_category')->nullable();
            //$table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');;
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
        Schema::dropIfExists('toyyibpays');
    }
};
