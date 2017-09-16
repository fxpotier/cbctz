<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagRelationsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('tag_relations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('reference_tag_id')->unsigned()->nullable();
			$table->foreign('reference_tag_id')->references('id')->on('tags');
			$table->integer('related_tag_id')->unsigned()->nullable();
			$table->foreign('related_tag_id')->references('id')->on('tags');
			$table->enum('type', ['inclusive', 'exclusive']);
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('tag_relations');
	}
}