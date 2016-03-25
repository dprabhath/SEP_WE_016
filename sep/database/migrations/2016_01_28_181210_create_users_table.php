<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nic');
			$table->string('email')->unique();
			$table->timestamps();
			$table->string('name');
			$table->string('password');
			$table->string('tp')->nullable()->unique();
			$table->string('pic');
			$table->string('level');
			$table->boolean('active');
			$table->boolean('verified');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
