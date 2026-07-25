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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('productname', 150);
            $table->string('slug', 180)->unique();
            $table->decimal('price', 12, 2);
            $table->decimal('pricediscount', 12, 2)->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('brandid')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('cateid')->constrained('categories')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
