<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersMatchedOrganizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('order_piece_organization', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_piece_id')->unsigned();
            $table->bigInteger('scrap_id')->unsigned();
            $table->enum('status', ['pending', 'replied'])->default('pending');
            $table->foreign('order_piece_id')->on('order_piece')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('scrap_id')->on('scraps')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
