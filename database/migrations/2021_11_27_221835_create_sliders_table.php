<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration {

	public function up()
	{
		Schema::create('sliders', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('section_id')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sliders');
	}
}
