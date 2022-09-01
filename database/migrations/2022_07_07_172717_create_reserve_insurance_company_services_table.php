<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReserveInsuranceCompanyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserve_insurance_company_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('service_type')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('nationality')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('car_model_id')->nullable();
            $table->string('car_class_id')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('number_plate')->nullable();
            $table->string('engine_size')->nullable();
            $table->string('number_of_cylinders')->nullable();
            $table->string('vehicle_value')->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('branch_id')->on('branches')->references('id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserve_insurance_company_services');
    }
}
