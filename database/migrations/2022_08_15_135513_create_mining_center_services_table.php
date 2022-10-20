<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiningCenterServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mining_center_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mining_center_id')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_ar')->nullable();
            $table->float('price',11,2)->nullable();
            $table->float('discount',11,2)->nullable();
            $table->enum('discount_type',['percentage','amount'])->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('available')->default(1)->nullable();
            $table->boolean('active')->default(1)->nullable();
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
        Schema::dropIfExists('mining_center_services');
    }
}
