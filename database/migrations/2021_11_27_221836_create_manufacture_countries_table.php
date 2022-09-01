<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufactureCountriesTable extends Migration {

	public function up()
	{
		Schema::create('manufacture_countries', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name_en')->nullable();
			$table->string('name_ar');
            $table->boolean('active')->default(1);
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('manufacture_countries');
	}
}
