<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuctionSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_subscription',function (Blueprint $table){
           $table->bigIncrements('id');
           $table->unsignedBigInteger('user_id');
           $table->unsignedBigInteger('auction_id');
           $table->timestamps();

            $table->foreign('auction_id')->on('auctions')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
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
