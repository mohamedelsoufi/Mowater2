<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration {

	public function up()
	{
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->text('logo')->nullable();
            $table->boolean('active')->default(1);
            $table->bigInteger('manufacture_country_id')->unsigned();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('brands');
	}
}
