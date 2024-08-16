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
		Schema::create('calendar', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('venue_id')->unsigned()->nullable();
			$table->enum('type', ['event', 'chalkysticks', 'software'])->default('event');
			$table->string('type_detail')->nullable();
			$table->string('source')->nullable();
			$table->string('title');
			$table->text('description');
			$table->dateTime('start_at')->nullable();
			$table->dateTime('end_at')->nullable();

			$table->unique(array('type', 'type_detail', 'title'));

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('calendar');
	}
};
