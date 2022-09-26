<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Delivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //delivery types


        //delivery man
        Schema::create('delivery_man', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('gender', ['male', 'female']);
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('available')->default(1);
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->unsignedBigInteger('car_class_id')->nullable();
            $table->string('conveyor_type')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('profile_picture')->nullable();
            $table->enum('status',['available', 'busy', 'not_available'])->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();

            $table->foreign('brand_id')->on('brands')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('car_model_id')->on('car_models')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('car_class_id')->on('car_classes')->references('id')->onUpdate('set null')->onDelete('set null');

        });


        //delivery reservations
        Schema::create('delivery_man_reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('delivery_man_id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality');
            $table->unsignedBigInteger('category_id');
            $table->string('from');
            $table->string('to');
            $table->string('address');
            $table->string('distinctive_mark');
            $table->timestamp('day_to_go');
            $table->string('request_type');
            $table->string('number_of_repetitions');
            $table->float('price',11,2)->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->string('status')->default('pending');

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
