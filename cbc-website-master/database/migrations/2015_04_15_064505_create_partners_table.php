<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('partners', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('picture_id')->unsigned();
			$table->foreign('picture_id')->references('id')->on('pictures');
			$table->string('name');
			$table->string('link');
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('partners');
	}
}