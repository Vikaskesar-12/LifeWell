<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();


            $table->string('title_en');
            $table->string('title_fr')->nullable();
            
            $table->string('slug_en')->unique();
            $table->string('slug_fr')->unique()->nullable();
            
            $table->text('summary_en')->nullable();
            $table->text('summary_fr')->nullable();
            
            $table->longText('description_en')->nullable();
            $table->longText('description_fr')->nullable();
            
            $table->longText('return_policy_en')->nullable();
            $table->longText('return_policy_fr')->nullable();
            
            $table->text('photo');
            $table->integer('stock')->default(1);
            $table->string('size')->default('M')->nullable();
            $table->enum('condition',['default','new','hot'])->default('default');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->float('price');
            $table->float('discount')->nullabale();
            $table->boolean('is_featured')->deault(false);
            $table->boolean('deal_of_the_day')->default(0);
            $table->boolean('on_sale')->default(0);
            $table->boolean('top_rated')->default(0);
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->unsignedBigInteger('child_cat_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('child_cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
