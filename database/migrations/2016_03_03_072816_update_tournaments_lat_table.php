<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('tournaments', function ($table) {
			$table->decimal('lat', 10, 6)->after('max_players');
			$table->decimal('lon', 10, 6)->after('max_players');

			$table->index(['lat', 'lon']);
		});

		DB::statement('ALTER TABLE tournaments ADD location POINT');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}
};
