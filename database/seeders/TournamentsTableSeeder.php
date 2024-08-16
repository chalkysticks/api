<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class TournamentsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('tournaments')->insert([
			'id' => 1,
			'owner_id' => 1,
			'venue_id' => 2,
			'entry_fee' => 15.00,
			'max_players' => 8,
			'begins_at' => '2016-01-01 19:00:00'
		]);
	}
}
