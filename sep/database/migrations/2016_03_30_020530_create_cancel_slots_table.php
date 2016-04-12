<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_slots', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->timestamps();
            $table->integer('did');
            $table->string('time');// what are the time periods that going to be canceled
            $table->date('slotdate'); // what is the date, check whether is it a past date first
            //$table->primary(array('id','did','slotdate'));
        });
        DB::statement('ALTER TABLE  `cancel_slots` DROP PRIMARY KEY , ADD PRIMARY KEY ( `did` ,`slotdate` ) ;');
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cancel_slots');
    }
}
