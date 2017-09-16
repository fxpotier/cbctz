<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up() {
		Schema::create('payments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->references('id')->on('users');
            $table->integer('user_mango_id')->unsigned()->nullable();
            $table->integer('wallet_id')->unsigned()->nullable();
            $table->integer('bank_id')->unsigned()->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 * @return void
	 */
	public function down() {
		Schema::drop('payments');
	}
}
