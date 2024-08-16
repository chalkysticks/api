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
            ADD `game_type` enum('8 ball', '9 ball', '10 ball', '1 pocket', '14.1 straight', 'snooker', '3 cushion', 'bank pool', 'russian pyramid', 'honolulu') DEFAULT NULL
            AFTER `bracket_type`
        ");
		DB::statement("
            ALTER TABLE `tournaments`
            ADD `read_more` varchar(150) DEFAULT NULL
            AFTER `description`
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
            REMOVE `game_type`
            AFTER `bracket_type`
        ");
		DB::statement("
            ALTER TABLE `tournaments`
            REMOVE `read_more`
            AFTER `description`
        ");
	}
};
