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
        Schema::create('spareparts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mobilephonemodel_id')->unsigned();
            $table->foreign('mobilephonemodel_id')->references('id')->on('mobilephonemodels')->onDelete('cascade')->onUpdate('cascade');
            $table->text('intrastat_code');
            $table->double('net_value', 15, 8);
            $table->integer('min_vol')->unsigned();
            $table->text('description');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('spareparts');
    }
}
