<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrafficClearingOfficeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic_clearing_office_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('traffic_clearing_service_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->unsignedBigInteger('car_class_id')->nullable();
            $table->string('manufacturing_year')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname');
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
            $table->enum('id_type',['passport','national_id'])->nullable();
            $table->string('personal_id')->nullable();
            $table->date('smart_card_expiry_date')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('number_plate')->nullable();
            $table->date('date')->nullable();
            $table->float('service_fees',11,2)->nullable();
            $table->float('service_price',11,2)->nullable();
            $table->boolean('is_mawater_card')->default('0')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->unsignedBigInteger('traffic_clearing_office_id')->nullable();

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
        Schema::dropIfExists('traffic_clearing_office_requests');
    }
}
