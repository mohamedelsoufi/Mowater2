<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayOffsTable extends Migration {

	public function up()
	{
        Schema::create('day_offs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->bigInteger('model_id');
            $table->date('date');
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('day_offs');
	}
}
