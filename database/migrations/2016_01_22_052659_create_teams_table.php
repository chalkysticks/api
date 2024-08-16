<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('teams', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('owner_id')->unsigned();
			$table->string('name');
			$table->enum('league_type', ['none', 'apa', 'napl', 'napa', 'bca']);
			$table->integer('league_id')->unsigned();
			$table->integer('rank')->unsigned()->default(0);
			$table->integer('wins')->unsigned()->default(0);
			$table->integer('losses')->unsigned()->default(0);
			$table->timestamps();

			$table->index(['owner_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('teams');
	}
};
