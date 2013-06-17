<?php

class Policy_Index_Weights {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$table = DB::table('index_weights');
		// Create index weights for policy
		$table->insert(array(
			'field_name' => 'title',
			'multiplier' => 3
		));
		$table->insert(array(
			'field_name' => 'notes',
			'multiplier' => 2
		));
		$table->insert(array(
			'field_name' => 'believes',
			'multiplier' => 2
		));
		$table->insert(array(
			'field_name' => 'resolves',
			'multiplier' => 2
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('index_weights')
			->where_in('field_name', array('title', 'notes', 'believes', 'resolves'))
			->delete();
	}

}