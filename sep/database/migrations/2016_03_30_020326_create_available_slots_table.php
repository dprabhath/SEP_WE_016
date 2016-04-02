<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailableSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('did');
            $table->string('sun');
            $table->string('mon');
            $table->string('tue');
            $table->string('wed');
            $table->string('thur');
            $table->string('fri');
            $table->string('sat');
            $table->string('period')->default("0.30");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('available_slots');
    }
}
