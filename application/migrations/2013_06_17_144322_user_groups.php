<?php

class User_Groups {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$table = DB::table('user_groups');
		$table->insert(array('name' => 'admin'));
		$table->insert(array('name' => 'exec'));
		$table->insert(array('name' => 'steering'));
		$table->insert(array('name' => 'suspended'));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('user_groups')
			->where_in(
				'name',
				array('admin', 'exec', 'steering', 'suspended')
			)
			->delete();		
	}

}