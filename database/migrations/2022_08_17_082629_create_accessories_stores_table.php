<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessoriesStoresTable extends Migration {

	public function up()
	{
		Schema::create('accessories_stores', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('logo')->nullable();
			$table->string('name_en')->nullable();
			$table->string('name_ar')->nullable();
			$table->string('description_en')->nullable();
			$table->string('description_ar')->nullable();
			$table->string('tax_number')->nullable();
			$table->string('address')->nullable();
			$table->bigInteger('city_id')->unsigned()->nullable();
			$table->integer('number_of_views')->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
			$table->boolean('reservation_availability')->nullable()->default(1);
			$table->boolean('reservation_active')->nullable()->default(1);
			$table->boolean('delivery_availability')->nullable()->default(1);
			$table->boolean('delivery_active')->nullable()->default(1);
			$table->boolean('available')->nullable()->default(1);
			$table->boolean('active')->nullable()->default(1);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('accessories_stores');
	}
}
