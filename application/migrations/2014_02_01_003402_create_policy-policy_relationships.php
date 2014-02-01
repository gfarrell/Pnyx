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
		Schema::table('policies', function($table) {
			$table->integer('rescinded_by')->unsigned()->nullable()->default(null);
			$table->integer('renewed_by')->unsigned()->nullable()->default(null);

			// And now the foreign keys
			$table->foreign('rescinded_by')->references('id')->on('policies');
			$table->foreign('renewed_by')->references('id')->on('policies');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('policies', function($table) {
			$table->drop_column('rescinded_by');
			$table->drop_column('renewed_by');
		});
	}

}