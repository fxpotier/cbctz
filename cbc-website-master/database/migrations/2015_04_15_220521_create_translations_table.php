<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('translations', function(Blueprint $table) {
			$table->increments('id');
			$table->morphs('translatable');
			$table->integer('translated_reference')->unsigned()->nullable();
			$table->integer('language_id')->unsigned()->nullable();
			$table->foreign('language_id')->references('id')->on('languages');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('translations');
	}
}