<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('teams')->insert([
			'id' => 1,
			'owner_id' => 1,
			'name' => 'My balls in your hand',
			'league_type' => 'napl',
			'league_id' => 10001,
			'rank' => 10,
			'wins' => 6,
			'losses' => 4
		]);

		DB::table('teams')->insert([
			'id' => 2,
			'owner_id' => 5,
			'name' => 'Hit it & Quit it',
			'league_type' => 'napl',
			'league_id' => 10002,
			'rank' => 9,
			'wins' => 4,
			'losses' => 6
		]);

		DB::table('teams')->insert([
			'id' => 3,
			'owner_id' => 5,
			'name' => 'Pink Tacos',
			'league_type' => 'apa',
			'league_id' => 1001,
			'rank' => 5,
			'wins' => 10,
			'losses' => 1
		]);

		DB::table('teams')->insert([
			'id' => 4,
			'owner_id' => 8,
			'name' => 'Poke N Runs',
			'league_type' => 'apa',
			'league_id' => 1001,
			'rank' => 5,
			'wins' => 10,
			'losses' => 1
		]);
	}
}
