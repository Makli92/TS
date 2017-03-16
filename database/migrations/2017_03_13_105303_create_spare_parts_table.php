<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mobile_phone_model_id')->unsigned();
            $table->foreign('mobile_phone_model_id')->references('id')->on('mobile_phone_models')->onDelete('cascade')->onUpdate('cascade');
            $table->text('intrastat_code');
            $table->double('net_value', 15, 8);
            $table->integer('min_vol')->unsigned();
            $table->text('description');
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
        Schema::drop('spare_parts');
    }
}
