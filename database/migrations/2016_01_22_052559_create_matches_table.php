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
		Schema::create('matches', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('night_id')->unsigned()->nullable();
			$table->integer('user1_id')->unsigned();
			$table->integer('user2_id')->unsigned();
			$table->boolean('is_win')->default(false);
			$table->boolean('is_loss')->default(false);
			$table->timestamps();
			$table->timestamp('ended_at')->nullable();

			$table->index(['night_id', 'user1_id', 'user2_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('matches');
	}
};
