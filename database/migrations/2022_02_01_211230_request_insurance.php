<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RequestInsurance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_type');
            $table->string('features')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('car_model_id');
            $table->unsignedBigInteger('car_class_id');
            $table->string('manufacturing_year');
            $table->string('chassis_number')->nullable();
            $table->string('number_plate')->nullable();
            $table->string('engine_size')->nullable();
            $table->string('number_of_cylinders')->nullable();
            $table->string('vehicle_value')->nullable();
            $table->boolean('is_accident_certificate')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
        });
        schema::create('request_insurance_organization', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_insurance_id')->unsigned();
            $table->unsignedBigInteger('organizationable_id');
            $table->string('organizationable_type');
            $table->float('price',11,2)->nullable();
            $table->string('status')->default('pending');
            $table->foreign('request_insurance_id')->on('request_insurances')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        //
    }
}
