<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration {

	public function up()
	{
		Schema::create('branches', function(Blueprint $table) {
			$table->bigIncrements('id');
            $table->string('branchable_type');
            $table->bigInteger('branchable_id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->bigInteger('area_id')->unsigned()->nullable();
            $table->text('address_en')->nullable();
            $table->text('address_ar')->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->boolean('reservation_active')->default(1);
            $table->boolean('reservation_availability')->default(1);
            $table->boolean('delivery_availability')->default(1);
            $table->boolean('availability')->default(1);
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
	}

	public function down()
	{
		Schema::drop('branches');
	}
}
