<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchResultsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('search_results', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('search_id')->unsigned()->nullable();
			$table->foreign('search_id')->references('id')->on('searches');
            $table->integer('slug_id')->unsigned()->nullable();
            $table->foreign('slug_id')->references('id')->on('slugs');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('search_results');
	}
}