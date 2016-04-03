<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorTreatment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_treatment', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('doctor_id');
            $table->string('name');
            $table->string('description');
            $table->string('conditions1');
            $table->string('conditions2');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->string('image4');
            $table->string('image5');
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
