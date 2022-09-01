<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailablePaymentMethodsTable extends Migration {

	public function up()
	{
        Schema::create('available_payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type');
            $table->bigInteger('model_id');
            $table->bigInteger('payment_method_id')->unsigned();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('available_payment_methods');
	}
}
