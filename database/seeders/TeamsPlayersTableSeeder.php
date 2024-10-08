<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class TeamsPlayersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('teamsplayers')->insert([
			'team_id' => 1,
			'user_id' => 1
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 1,
			'user_id' => 2
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 1,
			'user_id' => 3
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 1,
			'user_id' => 4
		]);

		DB::table('teamsplayers')->insert([
			'team_id' => 2,
			'user_id' => 5
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 2,
			'user_id' => 6
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 2,
			'user_id' => 7
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 2,
			'user_id' => 8
		]);

		DB::table('teamsplayers')->insert([
			'team_id' => 3,
			'user_id' => 5
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 3,
			'user_id' => 9
		]);

		DB::table('teamsplayers')->insert([
			'team_id' => 4,
			'user_id' => 8
		]);
		DB::table('teamsplayers')->insert([
			'team_id' => 4,
			'user_id' => 10
		]);

	}
}
