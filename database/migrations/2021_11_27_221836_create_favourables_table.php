<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavourablesTable extends Migration {

	public function up()
	{
        Schema::create('favourables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('favourable_type');
            $table->bigInteger('favourable_id');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('favourables');
	}
}
