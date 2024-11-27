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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');
            $table->string('birthday');
            $table->string('ic');
            $table->string('work_id');
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('picture')->default('empty.png');
            $table->string('position');
            $table->boolean('status')->default(true);
            $table->string('date_register')->nullable();
            $table->string('user_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
