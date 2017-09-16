<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaggablesTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('taggables', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('taggable');
			$table->integer('tag_id')->unsigned()->nullable();
			$table->foreign('tag_id')->references('id')->on('tags');
			$table->integer('weight');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('taggables');
	}
}