<?php

namespace App\Console\Commands\VenueBuilder;

use Illuminate\Console\Command;

/**
 * @class CitiesTest
 * @package Console/Commands/VenueBuilder
 * @project ChalkySticks API
 */
class CitiesTest extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'venuebuilder:cities-test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		// Test cities
		$this->TestDataExists();

		// Test folders
		$this->TestFoldersExist();
	}

	protected function TestDataExists() {
		$cities_data_filepath = resource_path('/data/us-cities.json');

		// Test if the file exists
		if (file_exists($cities_data_filepath)) {
			$this->info('[OK] Cities data exists.');
		} else {
			$this->error('[ERR] Cities data does not exist.');
			exit;
		}

		// Test data itself
		$json = json_decode(file_get_contents($cities_data_filepath));

		if (count($json) > 100) {
			$this->info('[OK] Cities found: ' . count($json));
		} else {
			$this->error('[ERR] Not enough city data');
			exit;
		}
	}

	protected function TestFoldersExist() {
		$dirs = array_filter(glob(storage_path('locations/us/*')));

		if (count($dirs) >= 49) {
			$this->info('[OK] All United States Exist');
		} else {
			$this->error('[ERR] We do not have folders setup for US data.');
			exit;
		}

		if (is_writeable(storage_path('locations/us/new york'))) {
			$this->info('[OK] Directories are writeable');
		} else {
			$this->error('[ERR] US/New York is not writeable');
			exit;
		}
	}
}
