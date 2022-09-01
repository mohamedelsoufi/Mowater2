<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorizablesTable extends Migration {

	public function up()
	{
		Schema::create('categorizables', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('categorizable_type');
			$table->bigInteger('categorizable_id');
            $table->bigInteger('category_id')->unsigned();
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('categorizables');
	}
}
