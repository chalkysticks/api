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
		Schema::create('tournamentsentries', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('tournament_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->decimal('price_paid', 10, 2)->default(0);
			$table->enum('status', ['pending', 'paid', 'refunded'])->default('pending');
			$table->timestamps();

			$table->unique(['tournament_id', 'user_id', 'name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tournamentsentries');
	}
};
