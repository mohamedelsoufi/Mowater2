<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DrivingTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driving_trainers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('gender', ['male', 'female']);
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('hour_price')->nullable();
            $table->enum('discount_type', array('percentage', 'amount'))->nullable();
            $table->float('discount', 8,2)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->unsignedBigInteger('car_class_id')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('conveyor_type')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('profile_picture')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('available')->default(1);
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();

            $table->foreign('brand_id')->on('brands')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('car_model_id')->on('car_models')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('car_class_id')->on('car_classes')->references('id')->onUpdate('set null')->onDelete('set null');
        });
        Schema::create('driving_trainers_reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driving_trainer_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality');
            $table->string('age')->nullable();
            $table->boolean('is_previous_license');
            $table->boolean('attended_the_theoretical_driving_training_session');
            $table->unsignedBigInteger('training_type_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->double('price');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('training_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['educational', 'assessment']);
            $table->string('category_ar')->nullable();
            $table->string('category_en')->nullable();
            $table->string('no_of_hours')->nullable();
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
