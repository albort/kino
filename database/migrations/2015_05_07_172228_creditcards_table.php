<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreditcardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credit_cards', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('comapny');
			$table->string('creditcard_number');
			$table->string('expiration_date');
			$table->integer('security_code');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('credit_cards');
	}

}
