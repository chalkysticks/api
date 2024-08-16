<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class VenuesRevisionsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('venuesrevisions')->insert([
			'id' => 1,
			'venue_id' => 1,
			'user_id' => 1,
			'data' => '{ "phone": "917-450-5331" }'
		]);
	}
}
