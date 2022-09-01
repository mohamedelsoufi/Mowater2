<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration {

	public function up()
	{
		Schema::create('services', function(Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('servable_type');
            $table->bigInteger('servable_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->float('price',11,2)->nullable();
            $table->float('fees',11,2)->nullable();
            $table->boolean('location_required')->nullable();
            $table->float('discount',11,2)->nullable();
            $table->enum('discount_type',array(['percentage','amount']))->nullable();
            $table->boolean('discount_availability')->nullable()->default(0);
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->boolean('available')->nullable()->default(1);
            $table->timestamps();

            $table->foreign('category_id')->on('categories')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('sub_category_id')->on('sub_categories')->references('id')->onUpdate('set null')->onDelete('set null');

        });
	}

	public function down()
	{
		Schema::drop('services');
	}
}
