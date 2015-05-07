<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SerieseasonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('serie_seasons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('serie_id')->unsigned();
			$table->integer('season_number');
			$table->integer('episodes');
			$table->string('director');
			$table->integer('year');
			$table->float('price');
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
		Schema::drop('serie_seasons');
	}

}
