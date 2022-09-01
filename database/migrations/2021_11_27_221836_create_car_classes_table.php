<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarClassesTable extends Migration {

	public function up()
	{
        Schema::create('car_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->boolean('active')->nullable()->default(1);
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('car_classes');
	}
}
