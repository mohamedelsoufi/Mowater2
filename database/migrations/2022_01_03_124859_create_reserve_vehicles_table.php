<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReserveVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserve_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('id_number')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
            $table->string('action_by')->nullable();
            $table->enum('id_type',['passport','national_id'])->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->float('price',11,2)->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')->on('vehicles')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('branch_id')->on('branches')->references('id');
            $table->foreign('color_id')->on('colors')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserve_vehicles');
    }
}
