<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class NightsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('nights')->insert([
			'id' => 1
		]);
	}
}
