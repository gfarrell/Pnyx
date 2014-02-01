<?php

class Create_Policy_Policy_Relationships {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// So policies need to be related to each other
		Schema::create('policy_policy', function($table) {
			$table->engine = 'InnoDB';

			$table->increments('id');
			
			$table->integer('parent_id')->unsigned();
			$table->integer('child_id')->unsigned();

			// Rescinds specifies the action:
			// 	if true, then parent rescinds child
			// 	if false, then parent renews child
			$table->boolean('rescinds')->default(false);

			// And now the foreign keys
			$table->foreign('parent_id')->references('id')->on('policies');
			$table->foreign('child_id')->references('id')->on('policies');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('policy_policy');
	}

}