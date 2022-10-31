<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration {

	public function up()
	{
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->string('symbol');
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('payment_methods');
	}
}
