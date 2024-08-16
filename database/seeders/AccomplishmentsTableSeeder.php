<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AccomplishmentsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('accomplishments')->insert([
			'id' => 1,
			'icon_url' => "http://m.chalkysticks.com/external-logo.png",
			'banner_url' => "http://m.chalkysticks.com/external-logo.png",
			'description' => "Earned for uploading a photo of yourself."
		]);

		DB::table('accomplishments')->insert([
			'id' => 2,
			'icon_url' => "http://m.chalkysticks.com/external-logo.png",
			'banner_url' => "http://m.chalkysticks.com/external-logo.png",
			'description' => "Earned for broadcasting your first beacon."
		]);

		DB::table('accomplishments')->insert([
			'id' => 3,
			'icon_url' => "http://m.chalkysticks.com/image/achievements/revisions-x1.png",
			'banner_url' => "http://m.chalkysticks.com/image/achievements/revisions-x1.png",
			'description' => "Earned for uploading a venue revision."
		]);

		DB::table('accomplishments')->insert([
			'id' => 4,
			'icon_url' => "http://m.chalkysticks.com/image/achievements/volunteer.png",
			'banner_url' => "http://m.chalkysticks.com/image/achievements/volunteer.png",
			'description' => "Earned for volunteering to help at early stages of ChalkySticks."
		]);

		DB::table('accomplishments')->insert([
			'id' => 5,
			'icon_url' => "http://m.chalkysticks.com/image/achievements/submitter-x1.png",
			'banner_url' => "http://m.chalkysticks.com/image/achievements/submitter-x1.png",
			'description' => "Earned for submitting a new venue for review."
		]);
	}
}
