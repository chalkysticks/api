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
		Schema::create('userswallet', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('challenger_id')->unsigned()->nullable();
			$table->integer('transaction');
			$table->enum('source', ['ad_play', 'game', 'beacon', 'checkin', 'tournament', 'submission', 'revision', 'collection', 'photo', 'diagram']);
			$table->integer('source_id');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')
				->default(DB::raw('CURRENT_TIMESTAMP'))
				->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

			$table->index(['user_id']);
		});

		Schema::create('usersprizes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('prize_id')->unsigned();
			$table->integer('value');
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')
				->default(DB::raw('CURRENT_TIMESTAMP'))
				->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

			$table->index(['user_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('userswallet');
		Schema::drop('usersprizes');
	}
};
