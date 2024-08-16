<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class BeaconsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('beacons')->insert([
			'id' => 1,
			'user_id' => 1,
			'lat' => 40.780578,
			'lon' => -73.978426,
			'status' => 'active',
			'keepalive' => 0
		]);

		DB::table('beacons')->insert([
			'id' => 2,
			'user_id' => 2,
			'lat' => 40.777578,
			'lon' => -73.968426,
			'status' => 'active',
			'keepalive' => 0
		]);

		DB::table('beacons')->insert([
			'id' => 3,
			'user_id' => 5,
			'lat' => 40.781278,
			'lon' => -73.977126,
			'status' => 'active',
			'keepalive' => 0
		]);
	}
}
