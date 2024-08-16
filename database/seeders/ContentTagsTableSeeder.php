<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ContentTagsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('content_tags')->insert([
			'content_id' => 6,
			'tag' => "pool-pad"
		]);

		DB::table('content_tags')->insert([
			'content_id' => 6,
			'tag' => "diagram-9-ball"
		]);
	}

}
