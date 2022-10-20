<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{

    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reservable_type');
            $table->bigInteger('reservable_id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('nationality');
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->unsignedBigInteger('car_class_id')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('number_plate')->nullable();
            $table->enum('id_type',['passport','national_id'])->nullable();
            $table->string('credit_card_number')->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->text('address')->nullable();
            $table->string('distinctive_mark')->nullable();
            $table->float('delivery_fees',11,2)->nullable();
            $table->date('delivery_day')->nullable();
            $table->float('price',11,2)->nullable();
            $table->float('deposit',11,2)->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->boolean('delivery')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->string('action_by')->nullable();
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('reservations');
    }
}
