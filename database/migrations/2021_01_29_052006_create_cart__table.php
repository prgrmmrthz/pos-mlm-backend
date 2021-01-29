<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('sales_id');
            $table->unsignedInteger('product_id');
            $table->float('price', 8,2)->default(0);
            $table->unsignedInteger('quantity');
            $table->float('subtotal', 10,2)->default(0);
            $table->unsignedTinyInteger('status');
            $table->unsignedSmallInteger('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
