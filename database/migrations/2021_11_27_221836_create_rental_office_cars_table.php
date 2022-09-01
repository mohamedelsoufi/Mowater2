<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalOfficeCarsTable extends Migration
{

    public function up()
    {
        Schema::create('rental_office_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rental_office_id')->unsigned();
            $table->string('vehicle_type')->nullable();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->bigInteger('car_model_id')->unsigned()->nullable();
            $table->bigInteger('car_class_id')->unsigned()->nullable();
            $table->string('manufacture_year')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->float('daily_rental_price',11,2)->nullable();
            $table->float('weekly_rental_price',11,2)->nullable();
            $table->float('monthly_rental_price',11,2)->nullable();
            $table->float('yearly_rental_price',11,2)->nullable();
            $table->string('ghamara_count')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->boolean('available')->nullable()->default(1);
            $table->timestamps();

            $table->foreign('brand_id')->on('brands')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('color_id')->on('colors')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('rental_office_cars');
    }
}
