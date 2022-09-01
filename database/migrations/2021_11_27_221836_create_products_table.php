<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('productable_type');
			$table->bigInteger('productable_id');
			$table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->bigInteger('car_model_id')->unsigned()->nullable();
            $table->bigInteger('car_class_id')->unsigned()->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->string('engine_size')->nullable();
            $table->float('price',11,2)->nullable();
            $table->boolean('warranty')->nullable();
            $table->string('status')->nullable();
            $table->enum('type', array('original', 'commercial'))->nullable()->default('original');
            $table->boolean('is_new')->nullable()->default(1);
            $table->float('discount',11,2)->nullable();
            $table->enum('discount_type',array(['percentage','amount']))->nullable();
            $table->boolean('discount_availability')->nullable()->default(0);
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->boolean('available')->nullable()->default(1);
            $table->timestamps();

            $table->foreign('brand_id')->on('brands')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('car_model_id')->on('car_models')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('car_class_id')->on('car_classes')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->on('categories')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('sub_category_id')->on('sub_categories')->references('id');
        });
	}

	public function down()
	{
		Schema::drop('products');
	}
}
