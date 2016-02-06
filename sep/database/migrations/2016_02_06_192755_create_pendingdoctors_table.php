<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingdoctorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('pendingdoctor');
		
		Schema::create('pendingdoctor', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('specialization');
			$table->string('notes');
			$table->string('profqual');
			$table->string('eduqual');
			$table->string('hospital');
			$table->bigInteger('phone');
			$table->string('email');
			$table->string('address');
			$table->float('rating');
			$table->string('user');
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
		Schema::drop('pendingdoctor');
	}

}
