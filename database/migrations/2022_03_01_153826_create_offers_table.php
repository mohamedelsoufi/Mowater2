<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('offerable');
            $table->unsignedBigInteger('discount_card_id')->nullable();
            $table->enum('discount_type',array(['percentage','amount']))->nullable();
            $table->float('discount_value',11,2)->nullable();
            $table->string('number_of_uses_times')->nullable();
            $table->integer('specific_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('discount_card_id')->references('id')->on('discount_cards')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
