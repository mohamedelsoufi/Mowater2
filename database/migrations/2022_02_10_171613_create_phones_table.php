<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->string('phoneable_type');
            $table->bigInteger('phoneable_id');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone');
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
