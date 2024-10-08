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
		Schema::create('participants', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('thread_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->timestamp('last_read')->nullable()
				->default(DB::raw('CURRENT_TIMESTAMP'))
				->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('participants');
	}
};
