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
        Schema::create('staff_users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 100);
            $table->string('username', 30)->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('phone', 20)->nullable()->unique();
            $table->string('address')->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->date('birthday')->nullable();
            $table->unsignedTinyInteger('role')->default(2);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_users');
    }
};
