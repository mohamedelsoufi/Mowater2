<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarWashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_washes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('reservation_availability')->nullable()->default(1);
            $table->boolean('reservation_active')->default(1);
            $table->boolean('available')->default(1);
            $table->boolean('active')->default(1);
            $table->string('created_by')->nullable()->default('system@app.com');
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
        Schema::dropIfExists('car_washes');
    }
}
