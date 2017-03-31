<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsWorkOrdersTable extends Migration
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
            $table->text('description');
            $table->text('notes');
            $table->integer('created_by_user_id')->unsigned()->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->integer('assigned_to_user_id')->unsigned()->nullable();
            $table->foreign('assigned_to_user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null')->onUpdate('cascade');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('work_order_statuses')->onDelete('set null')->onUpdate('cascade');
            $table->integer('device_id')->unsigned()->nullable();
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('set null')->onUpdate('cascade');
            $table->integer('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('set null')->onUpdate('cascade');
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
