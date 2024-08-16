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
		Schema::create('tv_schedule', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->nullable();
			$table->string('description')->nullable();
			$table->integer('duration')->unsigned()->nullable();
			$table->string('video_meta')->nullable();
			$table->string('embed_url')->nullable();
			$table->boolean('is_live')->nullable();
			$table->dateTime('air_at')->nullable();

			$table->timestamps();
		});

		Schema::create('tv_settings', function (Blueprint $table) {
			$table->string('key')->nullable();
			$table->string('value')->nullable();

			$table->index(['key']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tv_schedule');
		Schema::drop('tv_settings');
	}
};
