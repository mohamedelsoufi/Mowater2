<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_piece', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('car_type');
            $table->string('car_model');
            $table->string('manufacturing_year');
            $table->string('piece_type');
            $table->boolean('piece_status')->nullable();
            $table->enum('status', ['pending', 'replied'])->default('pending');
            $table->enum('veihcle_number', ['original', 'copy'])->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
