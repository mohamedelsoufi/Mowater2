<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalOfficeCarProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_office_car_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rental_office_car_id');
            $table->unsignedBigInteger('rental_property_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_office_car_properties');
    }
}
