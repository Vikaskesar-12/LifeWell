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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Size, Color
            $table->string('code')->unique(); // e.g. size, color
            $table->enum('type', [
                'text',
                'select',
                'multiselect',
                'boolean',
                'textarea',
                'price',
                'datetime',
                'date',
                'image',
                'file',
                'checkbox'
            ]);
                        $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
