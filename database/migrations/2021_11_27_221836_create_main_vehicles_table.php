<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainVehiclesTable extends Migration {

	public function up()
	{
		Schema::create('main_vehicles', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->enum('vehicle_type', array('trucks', 'pickups', 'cars','motorcycles','cruisers'))->nullable();
			$table->bigInteger('brand_id')->unsigned()->nullable();
			$table->bigInteger('car_model_id')->unsigned()->nullable();
			$table->string('manufacturing_year')->nullable();
			$table->bigInteger('car_class_id')->unsigned()->nullable();
			$table->string('body_shape')->nullable();
			$table->string('engine')->nullable();
			$table->string('fuel_type')->nullable();
			$table->string('passengers_number')->nullable();
			$table->string('doors_number')->nullable();
			$table->boolean('start_engine_with_button')->nullable();
			$table->boolean('seat_adjustment')->nullable();
			$table->string('steering_wheel')->nullable();
			$table->boolean('ambient_interior_lighting')->nullable();
			$table->boolean('seat_heating_cooling_function')->nullable();
			$table->boolean('remote_engine_start')->nullable();
			$table->boolean('manual_steering_wheel_tilt_and_movement')->nullable();
			$table->boolean('automatic_steering_wheel_tilt_and_movement')->nullable();
			$table->boolean('child_seat_restraint_system')->nullable();
			$table->boolean('steering_wheel_controls')->nullable();
			$table->string('seat_upholstery')->nullable();
			$table->boolean('air_conditioning_system')->nullable();
			$table->string('electric_windows')->nullable();
			$table->string('car_info_screen')->nullable();
			$table->boolean('seat_memory_feature')->nullable();
			$table->string('sunroof')->nullable();
			$table->boolean('interior_embroidery')->nullable();
			$table->boolean('side_awnings')->nullable();
			$table->boolean('seat_massage_feature')->nullable();
			$table->boolean('air_filtration')->nullable();
			$table->string('car_gear_shift_knob')->nullable();
			$table->string('front_lighting')->nullable();
			$table->boolean('side_mirror')->nullable();
			$table->string('tire_type_and_size')->nullable();
			$table->boolean('roof_rails')->nullable();
			$table->boolean('electric_back_door')->nullable();
			$table->string('transparent_coating')->nullable();
			$table->boolean('toughened_glass')->nullable();
			$table->string('back_lights')->nullable();
			$table->boolean('fog_lights')->nullable();
			$table->boolean('daytime_running_lights')->nullable();
			$table->boolean('automatically_closing_doors')->nullable();
			$table->string('roof')->nullable();
			$table->boolean('rear_spoiler')->nullable();
			$table->boolean('Electric_height_adjustment_for_headlights')->nullable();
			$table->string('back_space')->nullable();
			$table->boolean('keyless_entry_feature')->nullable();
			$table->boolean('sensitive_windshield_wipers_rain')->nullable();
			$table->string('weight')->nullable();
			$table->string('injection_type')->nullable();
			$table->string('determination')->nullable();
			$table->string('fuel_tank_capacity')->nullable();
			$table->string('fuel_consumption')->nullable();
			$table->timestamps();

            $table->foreign('brand_id')->on('brands')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('car_model_id')->on('car_models')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('car_class_id')->on('car_classes')->references('id')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('main_vehicles');
	}
}
