<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationsTable extends Migration {

	public function up()
	{
        Schema::create('verifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->bigInteger('model_id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('verifications');
	}
}
