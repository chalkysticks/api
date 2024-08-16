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
		Schema::create('beaconsarchive', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->decimal('lat', 10, 6);
			$table->decimal('lon', 10, 6);
			$table->enum('status', ['active', 'connected', 'inactive']);
			$table->boolean('keepalive');
			$table->timestamps();
		});
		DB::statement('ALTER TABLE beaconsarchive ADD location POINT');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('beaconsarchive');
	}
};
