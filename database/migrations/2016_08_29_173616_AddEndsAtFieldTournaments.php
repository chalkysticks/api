<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement("
            ALTER TABLE `tournaments`
            ADD `ends_at` DATETIME DEFAULT NULL
            AFTER `begins_at`
        ");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement("
            ALTER TABLE `tournaments`
            REMOVE `ends_at`
            AFTER `begins_at`
        ");
	}
};
