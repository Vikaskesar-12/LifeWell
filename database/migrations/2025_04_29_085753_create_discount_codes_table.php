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
       // database/migrations/xxxx_xx_xx_create_discount_codes_table.php
Schema::create('discount_codes', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique(); // Discount code e.g., SAVE10
    $table->enum('type', ['percentage', 'fixed'])->default('percentage'); // Type of discount
    $table->decimal('amount', 8, 2); // Amount (10 for 10%, or 50 for ₹50)
    $table->integer('usage_limit')->nullable(); // Max usage count
    $table->integer('used_count')->default(0); // How many times used
    $table->dateTime('starts_at')->nullable();
    $table->dateTime('expires_at')->nullable();
    $table->boolean('status')->default(true); // Active/inactive
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
