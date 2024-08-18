<?php

namespace App\Console\Commands\VenueBuilder;

use Illuminate\Console\Command;
use File;

/**
 * @class CitiesCreate
 * @package Console/Commands/VenueBuilder
 * @project ChalkySticks API
 */
class CitiesCreate extends Command {
	/**
	 * @var string
	 */
	protected $signature = 'venuebuilder:cities-create {--file=} {--country=us}';

	/**
	 * @var string
	 */
	protected $input_file;

	/**
	 * @var string
	 */
	protected $output_folder;

	/**
	 * @var array
	 */
	private $countries = ['ca', 'de', 'mx', 'nz', 'uk', 'us'];

	/**
	 * @return void
	 */
	public function handle() {
		$file = $this->option('file') ?: '';
		$country = $this->option('country') ?: '';

		// Define local variables
		if ($file && $country) {
			$this->create($file, $country);
		} else {
			foreach ($this->countries as $country) {
				$this->create("{$country}-cities", $country);
			}
		}
	}

	/**
	 * @param string $file
	 * @param string $country
	 * @return void
	 */
	protected function create(string $file, string $country) {
		$this->input_file = base_path("/resources/data/$file.json");
		$this->output_folder = storage_path('/locations');

		// Create data
		$json = file_get_contents($this->input_file);
		$data = json_decode($json);

		// Generate Index
		// $this->CreateIndex($data);

		// Generate Folder Structures
		$this->CreateLocations($data, $country);
	}

	protected function CreateIndex($data) {
		$output = (object) [];

		foreach ($data as $value) {
			$city = $value->city;
			$state = $value->state;
			$key = strtolower("us-$state-$city");

			$output->$key = (object) [
				'last_checked' => 0,
				'results_found' => 0,
				'confirmed_locations' => -1,
				'questionable_locations' => -1
			];
		}

		$json = json_encode($output);

		file_put_contents($this->output_folder . '/index.json', $json);
	}

	protected function CreateLocations($data, $country = 'us') {
		$filepath = storage_path('locations/' . $country);

		// Create base dir if not exists
		if (!file_exists($filepath)) {
			File::makeDirectory($filepath, $mode = 0777, true, true);
		}

		// Create folders
		foreach ($data as $value) {
			$city = strtolower($value->city);
			$state = strtolower($value->state);

			// Create Folders
			$this->CreateLocation($city, $state, $country);
		}
	}

	protected function CreateLocation($city, $state, $country = 'us') {
		$folder = $this->output_folder;

		// Test Country
		if (!file_exists("$folder/$country")) {
			File::makeDirectory("$folder/$country", $mode = 0777, true, true);
		}

		// Test State
		if (!file_exists("$folder/$country/$state")) {
			File::makeDirectory("$folder/$country/$state", $mode = 0777, true, true);
		}

		// Test City
		if (!file_exists("$folder/$country/$state/$city")) {
			File::makeDirectory("$folder/$country/$state/$city", $mode = 0777, true, true);
		}
	}

}
