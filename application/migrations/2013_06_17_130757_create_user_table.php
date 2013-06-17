<?php

class Create_User_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create users table
		Schema::create('users', function($table) {
			$table->increments('id');
			$table->string('crsid', 25);

			$table->timestamps();
		});

		// Create user groups table
		Schema::create('user_groups', function($table){
			$table->increments('id');
			$table->string('name', 50)->unique();

			$table->timestamps();
		});

		// Pivot table
		Schema::create('user_usergroup', function($table){
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('usergroup_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('usergroup_id')->references('id')->on('user_groups');
			
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop Pivot table
		Schema::drop('user_usergroup');
		// Drop groups
		Schema::drop('user_groups');
		// Drop users
		Schema::drop('users');
	}

}