<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsResetTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reset_tokens', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->integer('owner_id');
            // $table->foreign('owner_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->integer('expire_time');
            $table->nullableTimestamps();
            $table->unique(['id', 'owner_id']);
            $table->index('owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reset_tokens');
    }
}
