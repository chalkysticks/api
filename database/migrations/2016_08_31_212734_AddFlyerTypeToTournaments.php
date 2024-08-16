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
            ADD `flyer_type` varchar(50) DEFAULT 'flyer-1'
            AFTER `game_type`
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
            REMOVE `flyer_type`
            AFTER `game_type`
        ");
	}
};
