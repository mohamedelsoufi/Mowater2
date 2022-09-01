<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessoriesTable extends Migration {

	public function up()
	{
		Schema::create('accessories', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('accessories_store_id')->unsigned()->nullable();
			$table->string('name_en')->nullable();
			$table->string('name_ar')->nullable();
			$table->string('description_en')->nullable();
			$table->string('description_ar')->nullable();
			$table->bigInteger('category_id')->unsigned()->nullable();
			$table->bigInteger('sub_category_id')->unsigned()->nullable();
			$table->bigInteger('brand_id')->unsigned()->nullable();
			$table->bigInteger('car_model_id')->unsigned()->nullable();
			$table->boolean('guarantee')->nullable()->default(0);
			$table->string('guarantee_year')->nullable();
			$table->string('guarantee_month')->nullable();
			$table->float('price', 8,2)->nullable();
			$table->enum('discount_type', array('percentage', 'amount'))->nullable();
			$table->float('discount', 8,2)->nullable();
			$table->integer('number_of_views')->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
			$table->boolean('available')->nullable()->default(1);
			$table->boolean('active')->nullable()->default(1);
			$table->timestamps();

            $table->foreign('accessories_store_id')->references('id')->on('accessories_stores')
                ->onDelete('cascade')
                ->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('accessories');
	}
}
