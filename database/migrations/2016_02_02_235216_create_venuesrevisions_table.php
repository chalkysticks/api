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
		Schema::create('venuesrevisions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('venue_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->text('data')->default('');
			$table->string('image_url')->nullable();
			$table->timestamps();

			$table->index(['venue_id', 'user_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('venuesrevisions');
	}
};
