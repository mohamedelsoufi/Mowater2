<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialNumbersTable extends Migration {

	public function up()
	{
		Schema::create('special_numbers', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('category_id')->unsigned()->nullable();
			$table->bigInteger('sub_category_id')->unsigned()->nullable();
			$table->string('number')->nullable();
			$table->string('size')->nullable();
			$table->enum('transfer_type', array('waiver', 'own'))->nullable();
			$table->float('price')->nullable();
            $table->float('discount',11,2)->nullable();
            $table->enum('discount_type',array(['percentage','amount']))->nullable();
			$table->boolean('Include_insurance')->nullable();
			$table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('special_number_organization_id')->unsigned()->nullable();
            $table->boolean('price_include_transfer')->default(1)->nullable();
            $table->boolean('is_special')->default(1)->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('availability')->default(1);
            $table->boolean('active')->default(1);
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();

            $table->foreign('category_id')->on('categories')->references('id')->onUpdate('cascade')->onUpdate('cascade');
            $table->foreign('sub_category_id')->on('sub_categories')->references('id')->onUpdate('cascade')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('special_numbers');
	}
}
