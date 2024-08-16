<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('games')->insert([
			'id' => 1,
			'match_id' => 1,
			'user1_id' => 1,
			'user2_id' => 2,
			'is_win' => false,
			'is_loss' => false
		]);

	}
}
