<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('travels', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('traveler_id')->unsigned()->nullable();
			$table->foreign('traveler_id')->references('id')->on('users');
			$table->integer('citizen_id')->unsigned()->nullable();
			$table->foreign('citizen_id')->references('id')->on('users');
			$table->integer('experience_id')->unsigned()->nullable();
			$table->foreign('experience_id')->references('id')->on('experiences');
			$table->integer('event_id')->unsigned()->nullable();
			$table->foreign('event_id')->references('id')->on('events');
            $table->integer('persons');
			$table->integer('feedback_state')->unsigned();
			$table->integer('signal')->unsigned();
			$table->enum('state', ['booked', 'done', 'denied', 'canceled', 'asked']);
			$table->dateTime('booked_at');
            $table->integer('payment_preauth_id')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('travels');
	}
}