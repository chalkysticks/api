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
		Schema::create('content', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('thumbnail_url');
			$table->string('media_url');
			$table->enum('media_type', ['image', 'video']);
			$table->text('content');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('content');
	}
};
