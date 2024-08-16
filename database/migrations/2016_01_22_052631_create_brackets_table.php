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
		Schema::create('brackets', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tournament_id')->unsigned();
			$table->integer('tournamententry_id')->unsigned();
			$table->enum('side', ['a', 'b'])->default('a');
			$table->integer('order')->unsigned();
			$table->integer('round')->unsigned();
			$table->timestamps();

			$table->index(['tournament_id', 'tournamententry_id', 'round', 'side']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('brackets');
	}
};
