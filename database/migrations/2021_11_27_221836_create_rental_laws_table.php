<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalLawsTable extends Migration {

	public function up()
	{
        Schema::create('rental_laws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rental_office_id')->unsigned();
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('rental_laws');
	}
}
