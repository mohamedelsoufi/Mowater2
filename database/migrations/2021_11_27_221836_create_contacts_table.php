<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration {

	public function up()
	{
        Schema::create('Contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contactable_type');
            $table->bigInteger('contactable_id');
            $table->text('facebook_link')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->text('website')->nullable();
            $table->text('instagram_link')->nullable();
            $table->timestamps();
        });
	}

	public function down()
    {
        Schema::drop('Contacts');
    }
}
