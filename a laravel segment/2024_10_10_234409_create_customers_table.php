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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('email')->primary();
            $table->numeric('price');
            $table->double('total');
            $table->string('picture')->default('empty.png');
            $table->string('ic')->nullable();
            $table->string('address')->nullable();
            $table->integer('point')->default(0);
            $table->string('user_email');
            $table->boolean('status')->default(true);
            $table->text('toyyip_key')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
