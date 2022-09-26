<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration {

	public function up()
	{
		Schema::create('areas', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name_en')->nullable();
			$table->string('name_ar')->nullable();
            $table->bigInteger('city_id')->unsigned();
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('areas');
	}
}
