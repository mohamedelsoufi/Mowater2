<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessoryStorePurchasesTable extends Migration {

	public function up()
	{
		Schema::create('accessory_store_purchases', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('accessories_store_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('nickname')->nullable();
			$table->string('nationality')->nullable();
			$table->string('country_code')->nullable();
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->bigInteger('brand_id')->unsigned()->nullable();
			$table->bigInteger('car_model_id')->unsigned()->nullable();
			$table->boolean('home_delivery')->nullable()->default(0);
			$table->boolean('is_mawater_card')->nullable()->default(0);
			$table->float('price', 8,2)->nullable();
			$table->timestamps();

            $table->foreign('accessories_store_id')->references('id')->on('accessories_stores')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('accessory_store_purchases');
	}
}
