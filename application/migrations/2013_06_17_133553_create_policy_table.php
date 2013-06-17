<?php

class Create_Policy_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create policy table
		Schema::create('policies', function($table){
			$table->increments('id');
			$table->string('title', 250);
			
			$table->date('date');
			$table->boolean('passed')->default(false);
			
			$table->string('notes', 2500)->nullable();
			$table->string('believes', 2500)->nullable();
			$table->string('resolves', 2500)->nullable();

			$table->string('votes_for', 10)->nullable();
			$table->string('votes_against', 10)->nullable();
			$table->string('votes_abstain', 10)->nullable();

			$table->string('proposed', 100);
			$table->string('seconded', 100);
		});

		// Create policy index table
		Schema::create('policy_indices', function($table){
			$table->engine = 'MyISAM'; // because it'll be used for indexing

			$table->increments('id');
			$table->string('data', 2500);
			$table->string('field_name', 50);
			$table->integer('policy_id')->unsigned();

			$table->fulltext('data'); // fulltext searching
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('policy_indices');
		Schema::drop('policies');
	}

}