<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienceLanguageTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('experience_language', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('experience_id')->unsigned()->nullable();
			$table->foreign('experience_id')->references('id')->on('experiences');
			$table->integer('language_id')->unsigned()->nullable();
			$table->foreign('language_id')->references('id')->on('languages');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('experience_language');
	}

}
