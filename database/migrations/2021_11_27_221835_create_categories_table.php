<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name_en')->nullable();
			$table->string('name_ar');
            $table->string('ref_name')->nullable();
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}
