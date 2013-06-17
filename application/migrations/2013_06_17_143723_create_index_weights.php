<?php

class Create_Index_Weights {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('index_weights', function($table){
			$table->increments('id');
			$table->string('field_name', 100);
			$table->integer('multiplier');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('index_weights');
	}

}