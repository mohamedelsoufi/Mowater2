<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCardUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_card_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('discount_card_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('barcode')->nullable();
            $table->string('vehicles')->nullable();
            $table->float('price',11,2)->default(0)->nullable();
            $table->timestamps();

            $table->foreign('discount_card_id')->references('id')->on('discount_cards')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_card_users');
    }
}
