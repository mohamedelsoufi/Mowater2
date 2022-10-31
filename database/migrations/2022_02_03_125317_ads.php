<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('organizationable_type')->nullable();
            $table->unsignedBigInteger('organizationable_id')->nullable();
            $table->string('module_type')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->float('price',11,2)->nullable();
            $table->boolean('negotiable')->default(0)->nullable();
            $table->unsignedBigInteger('ad_type_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('active')->default(1)->nullable();
            $table->enum('status',['pending','approved','rejected'])->default('approved')->nullable();
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();

            $table->foreign('country_id')
                ->references('id')->on('countries');
            $table->foreign('city_id')
                ->references('id')->on('cities');
            $table->foreign('area_id')
                ->references('id')->on('areas');
                        $table->foreign('ad_type_id')
                ->references('id')->on('ad_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
