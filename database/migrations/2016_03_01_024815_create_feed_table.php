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
		Schema::create('feed', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('type');
			$table->decimal('lat', 10, 6);
			$table->decimal('lon', 10, 6);
			$table->text('data');
			$table->string('notes');
			$table->timestamps();

			$table->index(['lat', 'lon', 'type']);
		});

		DB::statement('ALTER TABLE feed ADD location POINT');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('feed');
	}
};
