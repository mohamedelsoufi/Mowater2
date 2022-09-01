<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration {

	public function up()
	{
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->bigInteger('model_id')->nullable();
            $table->text('path')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('color_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('color_id')->references('id')->on('colors')->onUpdate('cascade')->onDelete('cascade');
        });
	}

	public function down()
	{
		Schema::drop('files');
	}
}
