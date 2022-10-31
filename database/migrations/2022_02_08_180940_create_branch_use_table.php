<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchUseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_use', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');

            $table->foreign('branch_id')->references('id')->on('branches')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->string('usable_type');
            $table->bigInteger('usable_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_use');
    }
}
