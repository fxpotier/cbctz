<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagCollectionTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('collection_tag', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('tag_id')->unsigned()->nullable();
			$table->foreign('tag_id')->references('id')->on('tags');
			$table->integer('collection_id')->unsigned()->nullable();
			$table->foreign('collection_id')->references('id')->on('collections');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('collection_tag');
	}
}