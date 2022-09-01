<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessoryStorePurchaseAccessoriesTable extends Migration {

	public function up()
	{
		Schema::create('accessory_store_purchase_accessories', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('accessory_store_purchase_id')->unsigned();
			$table->bigInteger('accessory_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('accessory_store_purchase_accessories');
	}
}
