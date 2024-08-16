<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class VenuesMediaTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('venuesmedia')->insert([
			'venue_id' => 1,
			'type' => 'image',
			'url' => 'http://s3-media3.fl.yelpcdn.com/bphoto/fiLONTZm6LfXRLg4pTZSEA/o.jpg'
		]);

		DB::table('venuesmedia')->insert([
			'venue_id' => 1,
			'type' => 'image',
			'url' => 'http://s3-media3.fl.yelpcdn.com/bphoto/fiLONTZm6LfXRLg4pTZSEA/o.jpg'
		]);


		DB::table('venuesmedia')->insert([
			'venue_id' => 2,
			'type' => 'image',
			'url' => 'http://s3-media2.fl.yelpcdn.com/bphoto/MUZ_V8vO40rvw-4M8_mkkA/o.jpg'
		]);

		DB::table('venuesmedia')->insert([
			'venue_id' => 2,
			'type' => 'image',
			'url' => 'http://s3-media4.fl.yelpcdn.com/bphoto/N3bsGWlrUrbra7M_9Vt03Q/o.jpg'
		]);


		DB::table('venuesmedia')->insert([
			'venue_id' => 3,
			'type' => 'image',
			'url' => 'http://s3-media1.fl.yelpcdn.com/bphoto/U2kYZvoY6RGPmppwylKYwg/o.jpg'
		]);

		DB::table('venuesmedia')->insert([
			'venue_id' => 3,
			'type' => 'image',
			'url' => 'http://s3-media3.fl.yelpcdn.com/bphoto/uKxiZOshELPhUbIWfZHKRA/o.jpg'
		]);


		DB::table('venuesmedia')->insert([
			'venue_id' => 4,
			'type' => 'image',
			'url' => 'http://s3-media1.fl.yelpcdn.com/bphoto/ZSNxKE7O6YS--BYfHeek-Q/o.jpg'
		]);

		DB::table('venuesmedia')->insert([
			'venue_id' => 4,
			'type' => 'image',
			'url' => 'http://s3-media4.fl.yelpcdn.com/bphoto/w251WelnNUptW_lb7Vnhzg/o.jpg'
		]);


		DB::table('venuesmedia')->insert([
			'venue_id' => 5,
			'type' => 'image',
			'url' => 'http://s3-media1.fl.yelpcdn.com/bphoto/5pSwUDywt8A2b22z2ksIxA/o.jpg'
		]);

		DB::table('venuesmedia')->insert([
			'venue_id' => 5,
			'type' => 'image',
			'url' => 'http://s3-media1.fl.yelpcdn.com/bphoto/D60_lBGa_zKc6Nx-3sCmyg/o.jpg'
		]);
	}
}
