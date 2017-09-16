<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacebookAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('facebook_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('account_id')->references('id')->on('account');
			$table->string('token');
			$table->text('long_token');
			$table->bigInteger('facebook_id')->unique();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('facebook_accounts');
	}

}
