<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration {

	public function up()
	{
		Schema::create('countries', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('cascade')->onDelete('cascade');
        });
	}

	public function down()
	{
		Schema::drop('countries');
	}
}
