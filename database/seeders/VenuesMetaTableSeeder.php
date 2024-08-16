<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class VenuesMetaTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('venuesmeta')->insert([
			'venue_id' => 1,
			'group' => 'details',
			'key' => '7-foot-table',
			'value' => '7\' Table'
		]);

		DB::table('venuesmeta')->insert([
			'venue_id' => 2,
			'group' => 'details',
			'key' => 'free',
			'value' => 'Free Table'
		]);
	}
}
