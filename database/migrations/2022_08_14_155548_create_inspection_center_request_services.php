<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionCenterRequestServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_center_request_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('request_technical_inspection_id');
            $table->unsignedBigInteger('technical_inspection_center_service_id');
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
        Schema::dropIfExists('inspection_center_request_services');
    }
}
