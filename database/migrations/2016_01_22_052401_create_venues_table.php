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
		Schema::create('venues', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->string('address');
			$table->string('city');
			$table->string('state');
			$table->string('zip')->nullable();
			$table->enum('type', ['bar', 'hall', 'hotel'])->default('bar');
			$table->string('phone', 25)->nullable();
			$table->decimal('lat', 10, 6);
			$table->decimal('lon', 10, 6);
			$table->text('description')->default('');
			$table->string('notes')->default('');
			$table->timestamps();

			$table->unique(['lat', 'lon']);
			$table->index(['lat', 'lon', 'type']);
		});
		DB::statement('ALTER TABLE venues ADD location POINT');

		/**
		 * @todo
		 * UNIQUE KEY `name` (`name`,`lat`,`lon`),
		 * KEY `lat` (`lat`,`lon`)
		 */
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('venues');
	}
};
