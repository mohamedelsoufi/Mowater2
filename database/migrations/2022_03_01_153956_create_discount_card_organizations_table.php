<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCardOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_card_organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('discount_card_id')->nullable();
            $table->string('organizable_type');
            $table->unsignedBigInteger('organizable_id');
            $table->boolean('active')->default(1)->nullable();
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
        Schema::dropIfExists('discount_card_organizations');
    }
}
