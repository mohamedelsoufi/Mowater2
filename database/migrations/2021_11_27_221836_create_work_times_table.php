<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimesTable extends Migration {

	public function up()
	{
        Schema::create('work_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('workable_type');
            $table->bigInteger('workable_id');
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->integer('duration')->nullable();
            $table->string('days')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('work_times');
	}
}
