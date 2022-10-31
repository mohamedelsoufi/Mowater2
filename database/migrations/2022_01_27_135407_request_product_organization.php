<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RequestProductOrganization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('car_model');
            $table->string('manufacturing_year');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('type', ['original', 'commercial'])->nullable();
            $table->boolean('is_new')->nullable();
            $table->enum('status', ['pending', 'replied'])->default('pending');
            $table->integer('vehicle_number')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();

            $table->timestamps();

            $table->foreign('category_id')->on('categories')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('brand_id')->on('brands')->references('id')->onUpdate('set null')->onDelete('set null');
            $table->foreign('user_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');

        });

        schema::create('request_product_organization', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_product_id')->unsigned();
            $table->unsignedBigInteger('organizationable_id');
            $table->string('organizationable_type');
            $table->float('price',11,2)->nullable();
//            $table->bigInteger('product_id')->unsigned();
            $table->string('status')->default('pending');
            $table->foreign('request_product_id')->on('request_products')->references('id')->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('product_id')->on('products')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

        });
        Schema::drop('order_piece_organization');
        Schema::drop('order_piece');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
