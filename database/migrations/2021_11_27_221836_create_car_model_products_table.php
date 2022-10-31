<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelProductsTable extends Migration
{

    public function up()
    {
        Schema::create('car_model_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('car_model_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->string('manufacturing_years')->nullable();
            $table->timestamps();
        });
	}

	public function down()
    {
        Schema::drop('car_model_products');
    }
}
