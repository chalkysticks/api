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
		Schema::create('tournaments', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('owner_id')->unsigned();
			$table->integer('host_id')->unsigned();
			$table->integer('venue_id')->unsigned();
			$table->enum('bracket_type', ['single', 'double'])->default('single');
			$table->decimal('entry_fee', 10, 2)->default(0);
			$table->integer('max_players')->unsigned()->default(8);
			$table->timestamps();
			$table->timestamp('begins_at')->after('max_players');

			$table->index(['owner_id', 'venue_id']);
			$table->unique(['venue_id', 'begins_at']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tournaments');
	}
};
