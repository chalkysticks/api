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
		Schema::create('teamsplayers', function (Blueprint $table) {
			$table->integer('team_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->timestamps();
			$table->primary(['team_id', 'user_id']);

			$table->index(['team_id', 'user_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('teamsplayers');
	}
};
