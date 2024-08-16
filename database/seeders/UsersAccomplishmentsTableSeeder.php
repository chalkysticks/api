<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UsersAccomplishmentsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('usersaccomplishments')->insert([
			'user_id' => 1,
			'accomplishment_id' => 1
		]);

		DB::table('usersaccomplishments')->insert([
			'user_id' => 1,
			'accomplishment_id' => 2
		]);
	}
}
