<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('doctors', function(Blueprint $table)
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
			$table->string('imagepath');
			$table->boolean('formal');
			$table->boolean('available')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('doctors');
	}

}
