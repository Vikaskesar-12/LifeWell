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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('base_price')->nullable();
            $table->string('price')->nullable();
            $table->string('stock')->nullable();
            $table->string('collection')->nullable();
            $table->string('discount')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
