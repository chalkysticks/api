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
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('phone', 15);
			$table->decimal('lat', 10, 6);
			$table->decimal('lon', 10, 6);
			$table->string('status', 20);
			$table->string('permissions', 255);
			$table->string('activation_key', 40);
			$table->rememberToken();
			$table->timestamps();

			$table->index(['lat', 'lon']);
		});
		DB::statement('ALTER TABLE users ADD location POINT');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}
};
