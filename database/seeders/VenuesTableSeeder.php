<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class VenuesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('venues')->insert([
			'id' => 1,
			'name' => "Parlour",
			'slug' => "parlour",
			'address' => "250 W 86th St. NY, NY 10024",
			'city' => "New York",
			'state' => "NY",
			'zip' => 10001,
			'type' => "bar",
			'phone' => "555-555-1234",
			'lat' => 40.7884,
			'lon' => -73.9771
		]);

		DB::table('venues')->insert([
			'id' => 2,
			'name' => "Superfine",
			'slug' => "superfine",
			'address' => "126 Front St. Brooklyn, NY 11201",
			'city' => "New York",
			'state' => "NY",
			'zip' => 10001,
			'type' => "bar",
			'phone' => "555-555-1234",
			'lat' => 40.7024,
			'lon' => -73.9875
		]);

		DB::table('venues')->insert([
			'id' => 3,
			'name' => "Eastside Billiards",
			'slug' => "eastside-billiards",
			'address' => "163 E 86th St. NY, NY 10028",
			'city' => "New York",
			'state' => "NY",
			'zip' => 10001,
			'type' => "hall",
			'phone' => "555-555-1234",
			'lat' => 40.7794,
			'lon' => -73.9545
		]);

		DB::table('venues')->insert([
			'id' => 4,
			'name' => "Amsterdam Billiards",
			'slug' => "amsterdam-billiards",
			'address' => "110 E 11th St. NY, NY 10003",
			'city' => "New York",
			'state' => "NY",
			'zip' => 10001,
			'type' => "hall",
			'phone' => "555-555-1234",
			'lat' => 40.7316,
			'lon' => -73.9896
		]);

		DB::table('venues')->insert([
			'id' => 5,
			'name' => "American Trash",
			'slug' => "american-trash",
			'address' => "1471 1st Ave New York, NY 10021",
			'city' => "New York",
			'state' => "NY",
			'zip' => 10001,
			'type' => "bar",
			'phone' => "555-555-1234",
			'lat' => 40.7709,
			'lon' => -73.9541
		]);
	}
}
