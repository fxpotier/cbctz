<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialRequestLanguageTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('special_request_language', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('special_request_id')->unsigned()->nullable();
			$table->foreign('special_request_id')->references('id')->on('special_requests');
			$table->integer('language_id')->unsigned()->nullable();
			$table->foreign('language_id')->references('id')->on('languages');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('special_request_language');
	}
}