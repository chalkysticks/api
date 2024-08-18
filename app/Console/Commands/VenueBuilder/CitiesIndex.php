<?php

namespace App\Console\Commands\VenueBuilder;

use Illuminate\Console\Command;

class CitiesIndex extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'venuebuilder:cities-index {--city=} {--state=} {--country=} {--confirmed=} {--questionable=} {--results=} ';

	/**
	 * JSON file with all the cities we're setting up
	 *
	 * @var string
	 */
	protected $index_file;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();

		$this->index_file = storage_path('/locations/index.json');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$json = file_get_contents($this->index_file);
		$data = json_decode($json);

		$city = strtolower($this->option('city'));
		$state = strtolower($this->option('state'));
		$country = strtolower($this->option('country') ?: 'US');

		$results = strtolower($this->option('results') ?: 0);
		$confirmed = strtolower($this->option('confirmed') ?: -1);
		$questionable = strtolower($this->option('questionable') ?: -1);

		$key = "$country-$state-$city";

		$data->$key->last_checked = time();
		$data->$key->results_found = $results;
		$data->$key->confirmed_locations = $confirmed;
		$data->$key->questionable_locations = $questionable;

		file_put_contents($this->index_file, json_encode($data));

		print_r($data->$key);
	}
}
