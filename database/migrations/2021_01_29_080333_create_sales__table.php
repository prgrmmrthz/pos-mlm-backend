<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedSmallInteger('customer_id')->default(0);
            $table->float('subtotal', 18,2)->default(0);
            $table->float('less', 18,2)->default(0);
            $table->float('total', 18,2)->default(0);
            $table->unsignedTinyInteger('mode')->default(1);
            $table->unsignedSmallInteger('user')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
