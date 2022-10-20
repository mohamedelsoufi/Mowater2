<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
			$table->string('email')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
			$table->string('password')->nullable();
			$table->boolean('active')->nullable()->default(1);
			$table->date('date_of_birth')->nullable();
			$table->enum('gender', array('male', 'female'))->nullable();
            $table->enum('nationality',array('GCC','Foreign'))->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
