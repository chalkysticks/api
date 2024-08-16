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
		Schema::create('innings', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('game_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('shots_taken')->unsigned()->default(0);
			$table->boolean('is_win')->default(false);
			$table->boolean('is_loss')->default(false);
			$table->timestamps();
			$table->timestamp('ended_at');

			$table->index(['game_id', 'user_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('innings');
	}
};
