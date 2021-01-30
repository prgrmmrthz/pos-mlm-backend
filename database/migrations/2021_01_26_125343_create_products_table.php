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
            $table->timestamps();
            $table->string('name', 100);
            $table->boolean('is_for_sale')->default(0);
            $table->integer('available_stock')->nullable();
            $table->unsignedSmallInteger('class_id')->nullable();
            $table->unsignedMediumInteger('flooring')->nullable();
            $table->unsignedMediumInteger('ceiling')->nullable();
            $table->float('unit_price', 8,2)->nullable();
            $table->float('retail_price', 8,2)->nullable();
            $table->float('wholesale_price', 8,2)->nullable();
            $table->unsignedMediumInteger('supplier_id')->nullable();
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
