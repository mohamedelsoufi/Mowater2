<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarShowroomsTable extends Migration
{

    public function up()
    {
        Schema::create('car_showrooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('tax_number')->nullable();
            $table->text('logo')->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('area_id')->unsigned()->nullable();
            $table->string('year_founded')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('reservation_availability')->nullable()->default(1);
            $table->boolean('delivery_availability')->nullable();
            $table->boolean('reservation_active')->nullable();
            $table->boolean('delivery_active')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('available')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('car_showrooms');
    }
}
