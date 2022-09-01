<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('vehicable');
            $table->enum('vehicle_type', array('cars','motorcycles','trucks','heavy_equipment','pickups','boats'))->nullable();
            $table->string('ghamara_count')->nullable();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->bigInteger('car_model_id')->unsigned()->nullable();
            $table->bigInteger('car_class_id')->unsigned()->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->boolean('is_new')->nullable();
            $table->string('traveled_distance')->default(0)->nullable();
            $table->string('traveled_distance_type')->nullable();
            $table->bigInteger('outside_color_id')->unsigned()->nullable();
            $table->bigInteger('inside_color_id')->unsigned()->nullable();
            $table->boolean('in_bahrain')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->boolean('guarantee')->nullable();
            $table->string('guarantee_month')->nullable();
            $table->string('guarantee_year')->nullable();
            $table->string('transmission_type')->nullable();//نوع القير
            $table->string('engine_size')->nullable();
            $table->string('cylinder_number')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('doors_number')->nullable();////*
            $table->boolean('start_engine_with_button')->nullable();////*
            $table->boolean('seat_adjustment')->nullable();////*
            $table->boolean('seat_heating_cooling_function')->nullable();////*
            $table->boolean('fog_lights')->nullable();////*
            $table->boolean('seat_massage_feature')->nullable(); //*
            $table->boolean('seat_memory_feature')->nullable(); //*
            $table->string('front_lighting')->nullable(); //*
            $table->boolean('electric_back_door')->nullable(); //*
            $table->string('wheel_drive_system')->nullable();
            $table->string('specifications')->nullable();
            $table->string('status')->nullable();
            $table->string('insurance')->nullable();
            $table->string('insurance_month')->nullable();
            $table->string('insurance_year')->nullable();
            $table->string('coverage_type')->nullable();
            $table->boolean('start_with_fingerprint')->nullable();
            $table->boolean('remote_start')->nullable();
            $table->boolean('screen')->nullable();
            $table->string('seat_upholstery')->nullable();
            $table->string('air_conditioning_system')->nullable();
            $table->string('windows_control')->nullable();
            $table->string('wheel_size')->nullable();
            $table->string('wheel_type')->nullable();
            $table->string('sunroof')->nullable();
            $table->boolean('selling_by_plate')->nullable();
            $table->string('number_plate')->nullable();
            $table->boolean('price_is_negotiable')->nullable();
            $table->string('location')->nullable();
            $table->text('additional_notes')->nullable();
            $table->float('price',11,2)->nullable();
            $table->float('discount',11,2)->nullable();
            $table->enum('discount_type',array(['percentage','amount']))->nullable();
            $table->boolean('mawatery_third_party')->default(0)->nullable();
            $table->string('user_vehicle_status')->nullable();

            $table->string('vehicle_name')->nullable();
            $table->string('chassis_number')->nullable()->unique();
            $table->string('battery_size')->nullable();
            $table->date('maintenance_history')->nullable();
            $table->string('maintenance_history_km')->nullable();
            $table->date('tire_installation_date')->nullable();
            $table->string('tire_installation_date_km')->nullable();
            $table->date('tire_warranty_expiration_date')->nullable();
            $table->string('tire_warranty_expiration_date_km')->nullable();
            $table->date('battery_installation_date')->nullable();
            $table->string('battery_installation_date_km')->nullable();
            $table->date('battery_warranty_expiry_date')->nullable();
            $table->string('battery_warranty_expiry_date_km')->nullable();
            $table->date('vehicle_registration_expiry_date')->nullable();
            $table->string('vehicle_registration_expiry_date_km')->nullable();
            $table->date('vehicle_insurance_expiry_date')->nullable();
            $table->string('vehicle_insurance_expiry_date_km')->nullable();

            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('availability')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();

            $table->foreign('brand_id')->on('brands')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('car_model_id')->on('car_models')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('car_class_id')->on('car_classes')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('outside_color_id')->references('id')->on('colors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('inside_color_id')->references('id')->on('colors')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
