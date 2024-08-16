<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class MatchesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// for brackets
		DB::table('matches')->insert([
			'id' => 1,
			'user1_id' => 1,
			'user2_id' => 2
		]);
		DB::table('matches')->insert([
			'id' => 2,
			'user1_id' => 3,
			'user2_id' => 4
		]);
		DB::table('matches')->insert([
			'id' => 3,
			'user1_id' => 5,
			'user2_id' => 6
		]);
		DB::table('matches')->insert([
			'id' => 4,
			'user1_id' => 7,
			'user2_id' => 8
		]);

		// for league nights
		DB::table('matches')->insert([
			'id' => 5,
			'night_id' => 1,
			'user1_id' => 2,
			'user2_id' => 3
		]);
		DB::table('matches')->insert([
			'id' => 6,
			'night_id' => 1,
			'user1_id' => 1,
			'user2_id' => 4
		]);
	}
}
