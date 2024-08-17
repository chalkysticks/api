<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('tvchannels', function (Blueprint $table) {
			$table->id();
			$table->string('youtube_id');
			$table->string('title');
			$table->text('description');
			$table->string('channel_id');
			$table->string('image_url');
			$table->timestamps();

			$table->unique('youtube_id');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('tvchannels');
	}
};
