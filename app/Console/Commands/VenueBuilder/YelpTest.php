<?php

namespace App\Console\Commands\VenueBuilder;

use Illuminate\Console\Command;

class YelpTest extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'venuebuilder:yelp-test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Test Yelp data';

	/**
	 * Yelp Client
	 */
	protected $client;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		$options = array(
			'apiHost' => env('YELP_API_HOST'),
			'apiKey' => env('YELP_V3_API_KEY')
		);

		$this->client = \Stevenmaguire\Yelp\ClientFactory::makeWith(
			$options,
			\Stevenmaguire\Yelp\Version::THREE
		);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$params = [
			'term' => 'pool hall',
			'location' => 'Chicago, IL',
			'radius' => 1609 * 1,   // meters
			'categories' => ['bars', 'pool'],
			// 'locale' => 'en_US',
			'limit' => 50,  // 50 is max
			'offset' => 0,  // paging by results
			'sort_by' => 'best_match',
			// 'price' => '1,2,3',
			// 'open_now' => true,
			// 'open_at' => 1234566,
			// 'attributes' => ['hot_and_new','deals']  // hot_and_new, request_a_quote, reservation, waitlist_reservation, cashback, deals, open_to_all
		];

		$results = $this->client->getBusinessesSearchResults($params);

		print_r($results);
		exit;
	}
}
