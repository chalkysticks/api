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
		Schema::table('transactions', function (Blueprint $table) {
			$table->dropUnique('transactions_type_id_user_id_status_unique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('transactions', function (Blueprint $table) {
			$table->unique(['type_id', 'user_id', 'status']);
		});
	}
};
