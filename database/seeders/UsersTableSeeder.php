<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('users')->insert([
			'id' => 1,
			'name' => "Matt Kenefick",
			'slug' => "matt-kenefick",
			'email' => 'keneficksays@gmail.com',
			'password' => hash_password('admin'),
			'phone' => '555-555-1234',
			'lat' => 40.790578,
			'lon' => -73.978426,
			'status' => '',
			'permissions' => '["super-admin", "venues", "venues.create", "venues.update", "venues.delete"]',
			'activation_key' => ''
		]);

		DB::table('users')->insert([
			'id' => 2,
			'name' => "Nina Masuda",
			'slug' => "nina-masuda",
			'email' => str_random(10) . '@gmail.com',
			'password' => hash_password('admin'),
			'phone' => '555-555-1234',
			'lat' => 40.710578,
			'lon' => -73.678426,
			'status' => '',
			'activation_key' => ''
		]);

		DB::table('users')->insert([
			'id' => 3,
			'name' => "Rigel Lastrella",
			'slug' => "rigel-lastrella",
			'email' => str_random(10) . '@gmail.com',
			'password' => hash_password('admin'),
			'phone' => '555-555-1234',
			'lat' => 40.7896682,
			'lon' => -73.9735766,
			'status' => '',
			'activation_key' => ''
		]);

		DB::table('users')->insert([
			'id' => 4,
			'name' => "Bob Medvedz",
			'slug' => "bob-medvedz",
			'email' => str_random(10) . '@gmail.com',
			'password' => hash_password('admin'),
			'phone' => '555-555-1234',
			'lat' => 40.7862240,
			'lon' => -73.9758082,
			'status' => '',
			'activation_key' => ''
		]);

		DB::table('users')->insert([
			'id' => 5,
			'name' => "Sheldon Anthony",
			'slug' => "sheldon-anthony",
			'email' => str_random(10) . '@gmail.com',
			'password' => hash_password('admin'),
			'phone' => '555-555-1234',
			'lat' => 40.7844694,
			'lon' => -73.9812155,
			'status' => '',
			'activation_key' => ''
		]);

		DB::table('users')->insert([
			'id' => 6,
			'name' => "Gary Carter",
			'slug' => "gary-carter",
			'email' => str_random(10) . '@gmail.com',
			'password' => hash_password('admin'),
			'phone' => '555-555-1234',
			'lat' => 40.7873938,
			'lon' => -73.9804430,
			'status' => '',
			'activation_key' => ''
		]);

		DB::table('users')->insert([
			'id' => 7,
			'name' => "Gordon Klimes",
			'slug' => "gordon-klimes",
			'email' => str_random(10) . '@gmail.com',
			'password' => hash_password('admin'),
			'phone' => '555-555-1234',
			'lat' => 40.7740379,
			'lon' => -73.9849062,
			'status' => '',
			'activation_key' => ''
		]);
	}
}
