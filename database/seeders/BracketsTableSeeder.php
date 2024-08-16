<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

/**
 * A "level" is how far out of the bracket we are.
 * The championship match would be level 0, the
 * playoffs would be level 1, and beyond 2, 3...
 */
class BracketsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('brackets')->insert([
			'tournament_id' => 1,
			'id' => 1,
			'level' => 2,
			'match_id' => 1
		]);

		DB::table('brackets')->insert([
			'tournament_id' => 1,
			'id' => 2,
			'level' => 2,
			'match_id' => 2
		]);

		DB::table('brackets')->insert([
			'tournament_id' => 1,
			'id' => 3,
			'level' => 2,
			'match_id' => 3
		]);

		DB::table('brackets')->insert([
			'tournament_id' => 1,
			'id' => 4,
			'level' => 2,
			'match_id' => 4
		]);

	}
}
