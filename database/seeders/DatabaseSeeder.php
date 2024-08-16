<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 */
	public function run(): void {
		// User::factory(10)->create();

		// User::factory()->create([
		// 	'name' => 'Test User',
		// 	'email' => 'test@example.com',
		// ]);

		// Order matters
		$this->call(AccomplishmentsTableSeeder::class);
		$this->call(BeaconsTableSeeder::class);
		$this->call(ContentTableSeeder::class);
		$this->call(ContentTagsTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(NightsTableSeeder::class);
		$this->call(MatchesTableSeeder::class);
		$this->call(GamesTableSeeder::class);
		$this->call(InningsTableSeeder::class);
		$this->call(TeamsPlayersTableSeeder::class);
		$this->call(TeamsTableSeeder::class);
		$this->call(UsersAccomplishmentsTableSeeder::class);
		$this->call(UsersMediaTableSeeder::class);
		$this->call(UsersMetaTableSeeder::class);
		$this->call(VenuesTableSeeder::class);
		$this->call(VenuesCheckinsTableSeeder::class);
		$this->call(VenuesMediaTableSeeder::class);
		$this->call(VenuesMetaTableSeeder::class);
		$this->call(VenuesRevisionsTableSeeder::class);
	}
}
