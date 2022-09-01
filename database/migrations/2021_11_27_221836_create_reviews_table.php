<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration {

	public function up()
	{
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reviewable_type');
            $table->bigInteger('reviewable_id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->float('rate')->nullable();
            $table->text('review')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('reviews');
	}
}
