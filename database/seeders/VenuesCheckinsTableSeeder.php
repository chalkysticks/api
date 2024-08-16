<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class VenuesCheckinsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('venuescheckins')->insert([
			'venue_id' => 1,
			'user_id' => 2
		]);

		DB::table('venuescheckins')->insert([
			'venue_id' => 1,
			'user_id' => 3
		]);

		DB::table('venuescheckins')->insert([
			'venue_id' => 1,
			'user_id' => 4
		]);

		DB::table('venuescheckins')->insert([
			'venue_id' => 1,
			'user_id' => 5
		]);
	}
}
