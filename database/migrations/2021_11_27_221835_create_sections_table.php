<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration {

	public function up()
	{
		Schema::create('sections', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar');
            $table->string('ref_name');
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->enum('reservation_cost_type', array('amount', 'percentage'))->nullable();
            $table->float('reservation_cost',11,2)->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('sections');
	}
}
