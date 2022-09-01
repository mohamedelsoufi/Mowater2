<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrafficClearingServiceUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic_clearing_service_uses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('traffic_clearing_service_id');
            $table->unsignedBigInteger('traffic_clearing_office_id');
            $table->float('fees',11,2)->nullable();
            $table->float('price',11,2)->nullable();
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
        Schema::dropIfExists('traffic_clearing_service_uses');
    }
}
