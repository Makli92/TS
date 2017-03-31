<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsWorkOrdersToSparePartsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders_to_spare_parts', function (Blueprint $table) {
            $table->integer('work_order_id')->unsigned();
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('spare_part_id')->unsigned();
            // $table->foreign('spare_part_id')->references('id')->on('spare_parts')->onDelete('set null')->onUpdate('cascade');
            $table->float('net_value', 8, 2);
            $table->float('vat_value', 8, 2);
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
        Schema::drop('work_orders_to_spare_parts');
    }
}
