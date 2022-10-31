<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialNumberReservationsTable extends Migration {

	public function up()
	{
        Schema::create('special_number_reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('special_number_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality');
            $table->enum('id_type',['passport','national_id'])->nullable();
            $table->string('credit_card_number')->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->float('price',11,2)->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('special_number_reservations');
	}
}
