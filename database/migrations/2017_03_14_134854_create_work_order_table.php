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
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('work_orders_spare_parts', function (Blueprint $table) {
            $table->integer('work_order_id')->unsigned();
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('spare_part_id')->unsigned();
            $table->foreign('spare_part_id')->references('id')->on('spare_parts')->onDelete('cascade')->onUpdate('cascade');

            $table->double('cost', 15, 8);

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
        Schema::drop('work_orders_spare_parts');
        Schema::drop('work_orders');
    }
}