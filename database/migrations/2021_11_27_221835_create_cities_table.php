<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration {

	public function up()
	{
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->bigInteger('country_id')->unsigned();
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('cities');
	}
}
