<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingEditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('pending_edit', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('doctorname');
            $table->integer('user_id');
            $table->string('username');
            $table->string('field');
            $table->string('value');
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
        //
    }
}
