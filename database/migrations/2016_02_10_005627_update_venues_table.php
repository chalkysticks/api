<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('venues', function ($table) {
			$table->string('country')->after('state')->nullable();
			$table->integer('status')->default(0)->after('id');
			$table->integer('owner_id')->unsigned()->nullable()->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('venues');
	}
};
