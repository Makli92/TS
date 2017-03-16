<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
            $table->text('imei');
            $table->text('description');
            $table->text('notes');
            $table->integer('technician_id')->unsigned();
            $table->foreign('technician_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('work_order_status_id')->unsigned();
            $table->foreign('work_order_status_id')->references('id')->on('work_order_statuses')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('work_orders');
    }
}
