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
            ALTER TABLE `users`
            ADD `social_id` varchar(50) DEFAULT NULL
            AFTER `id`
        ");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement("
            ALTER TABLE `users`
            REMOVE `social_id` varchar(50) DEFAULT NULL
            AFTER `id`
        ");
	}
};
