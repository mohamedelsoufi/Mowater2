<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Brokers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brokers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
//            $table->text('requirements_en')->nullable();
//            $table->text('requirements_ar')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('year_founded')->nullable();
            $table->boolean('reservation_availability')->nullable()->default(1);
            $table->boolean('reservation_active')->nullable()->default(1);
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('area_id')->unsigned()->nullable();
            $table->text('logo')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('available')->default(1);
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
        });

        //brokers_reservation
        Schema::create('broker_reservations', function (Blueprint $table) {
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
        //
    }
}
