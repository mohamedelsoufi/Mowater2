<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrivingTrainerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driving_trainer_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('driving_trainer_id')->nullable();
            $table->unsignedBigInteger('training_type_id')->nullable();
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
        Schema::dropIfExists('driving_trainer_offers');
    }
}
