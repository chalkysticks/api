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
		Schema::create('tvschedule', function (Blueprint $table) {
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

		Schema::create('tvsettings', function (Blueprint $table) {
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
		Schema::drop('tvschedule');
		Schema::drop('tvsettings');
	}
};
