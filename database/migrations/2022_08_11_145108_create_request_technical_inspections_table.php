<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestTechnicalInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_technical_inspections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('technical_inspection_center_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('nationality');
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->unsignedBigInteger('car_class_id')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('number_plate')->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->float('price',11,2)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('status')->nullable()->default('pending');
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
        Schema::dropIfExists('request_technical_inspections');
    }
}
