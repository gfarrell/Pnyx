<?php

class The_Emperor_Descends {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$user_id = DB::table('users')->insert_get_id(array('crsid'=>'gtf21'));

		// Find admin group
		$group_id = DB::table('user_groups')->where('name', '=', 'admin')->only('id');

		// Make gtf21 an admin
		DB::table('user_usergroup')->insert(array(
			'user_id'	   => $user_id,
			'usergroup_id' => $group_id
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('users')->where('crsid', '=', 'gtf21')->delete();
	}
}