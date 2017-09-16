<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->datetime('expiration_date');
			$table->integer('account_id')->references('id')->on('accounts');
			$table->string('token', 40);
			$table->enum('type', ['activation', 'reset_password']);
			$table->unique(['type', 'account_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('tokens');
	}
}
