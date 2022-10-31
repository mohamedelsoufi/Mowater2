<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsuranceCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //insurance companies table

        Schema::create('insurance_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('area_id')->unsigned()->nullable();
            $table->string('tax_number')->nullable();
            $table->string('year_founded')->nullable();
            $table->string('logo')->nullable();
            $table->integer('number_of_views')->default(0)->nullable();
            $table->boolean('active_number_of_views')->default(1)->nullable();
            $table->boolean('reservation_availability')->nullable()->default(1);
            $table->boolean('reservation_active')->nullable()->default(1);
            $table->boolean('active')->default(1);
            $table->boolean('available')->default(1);
            $table->string('created_by')->nullable()->default('system@app.com');
            $table->timestamps();
        });

        //isurance laws
        Schema::create('insurance_company_laws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('lawable');
            $table->string('law_en');
            $table->string('law_ar');
            $table->timestamps();
        });

        //coverage types
        Schema::create('coverage_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->timestamps();
        });

//        Schema::create('coveragables', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->morphs('coveragable');
//            $table->unsignedBigInteger('coverage_type_id')->nullable();
//            $table->float('price',11,2)->nullable();
//            $table->timestamps();
//            $table->foreign('coverage_type_id')->references('id')->on('coverage_types')->onDelete('cascade');
//
//        });

        //features
        Schema::create('features', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
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
        //
    }
}
