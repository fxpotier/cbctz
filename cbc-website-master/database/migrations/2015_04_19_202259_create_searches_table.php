<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchesTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('searches', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('account_id')->unsigned()->nullable();
			$table->foreign('account_id')->references('id')->on('accounts');
			$table->string('input');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('searches');
	}
}