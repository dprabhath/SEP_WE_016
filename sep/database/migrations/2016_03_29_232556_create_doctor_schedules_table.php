<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('did');
            $table->integer('uid');
            $table->dateTime('schedule_start'); //schedule time
            $table->dateTime('schedule_end');
            $table->string('code'); // send for the patient, to give it to the doctor
            $table->integer('trys'); //for security code entering to check is it a bruteforce
            $table->boolean('confirmed')->default(0); // is it confirmed by the doctor, doctor have to confirmed it before oneday
            $table->boolean('cancelUser')->default(0); // cancelation requested by the user and that cancalation cannot be undone becuase in the meantime someone else can be take that time slot
            $table->boolean('cancelDoctor')->default(0); // cancelation requested by the doctor and that cancaltion cannot be undone becuase in the meantime someone else can be take that time slot
            $table->boolean('completed')->default(0); // patient have to give the code to the doctor and doctor can set this to 1 by entering the code

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doctor_schedules');
    }
}
