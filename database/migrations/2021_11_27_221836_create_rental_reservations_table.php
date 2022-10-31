<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalReservationsTable extends Migration {

	public function up()
	{
		Schema::create('rental_reservations', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('rental_office_car_id')->unsigned()->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality');
            $table->enum('id_type',['passport','national_id'])->nullable();
            $table->string('id_number')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->float('insurance_amount',11,2)->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->string('receive_type')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->float('price',11,2)->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->timestamps();

        });
	}

	public function down()
	{
		Schema::drop('rental_reservations');
	}
}
