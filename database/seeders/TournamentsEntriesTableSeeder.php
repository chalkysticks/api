<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class TournamentsEntriesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('tournamentsentries')->insert([
			'tournament_id' => 1,
			'user_id' => 1,
			'price_paid' => 15.00,
			'status' => 'paid'
		]);

		DB::table('tournamentsentries')->insert([
			'tournament_id' => 1,
			'user_id' => 2,
			'price_paid' => 15.00,
			'status' => 'paid'
		]);

		DB::table('tournamentsentries')->insert([
			'tournament_id' => 1,
			'user_id' => 3,
			'price_paid' => 15.00,
			'status' => 'paid'
		]);
	}
}
