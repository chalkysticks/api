<?php

namespace App\Console\Commands\Database;

use App\Models;
use Illuminate\Console\Command;

/**
 * @class SeedFromCsv
 * @package Console/Commands/News
 * @project ChalkySticks API
 */
class SeedFromCsv extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'database:seed-from-csv {table}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Attempts to seed table via a CSV file';

	/**
	 * The table and structures may change over time so we map the files
	 * we'll encouter to the qualified name of our models
	 *
	 * @var array
	 */
	private $filemap = [
		'accomplishments' => Models\Accomplishment::class,
		'beacons' => Models\Beacon::class,
		'beaconsarchive' => Models\BeaconArchive::class,
		'calendar' => Models\Calendar::class,
		'content' => Models\Content::class,
		'content_tags' => Models\ContentTag::class,
		'diagrams' => Models\Diagram::class,
		'feed' => Models\Feed::class,
		'games' => Models\Game::class,
		'innings' => Models\GameInning::class,
		'matches' => Models\GameMatch::class,
		'nights' => Models\GameNight::class,
		'payoutaccounts' => Models\PayoutAccount::class,
		'products' => Models\Product::class,
		'teams' => Models\Team::class,
		'teamsplayers' => Models\TeamPlayer::class,
		'transactions' => Models\Transaction::class,
		'tv_schedule' => Models\TvSchedule::class,
		'tv_settings' => Models\TvSetting::class,
		'users' => Models\User::class,
		'usersaccomplishments' => Models\UserAccomplishment::class,
		'usersfriends' => Models\UserFriend::class,
		'usersmedia' => Models\UserMedia::class,
		'usersmeta' => Models\UserMeta::class,
		'userspaymentaccount' => Models\UserPaymentAccount::class,
		'usersprizes' => Models\UserPrize::class,
		'userswallet' => Models\UserWallet::class,
		'venues' => Models\Venue::class,
		'venuescheckins' => Models\VenueCheckin::class,
		'venuesmedia' => Models\VenueMedia::class,
		'venuesmeta' => Models\VenueMeta::class,
		'venuesrevisions' => Models\VenueRevision::class,
	];

	/**
	 * Execute the console command.
	 */
	public function handle() {
		$table = current(explode('.', $this->argument('table')));
		$fullpath = resource_path("seeder/csv/$table.csv");

		// Check if it exists
		if (!file_exists($fullpath)) {
			$this->error("File not found: $fullpath");
			return;
		}

		// Check if we have an associated model
		if (!isset($this->filemap[$table])) {
			$this->error("No model found for table: $table");
			return;
		}

		// Read through the CSV line by line
		$rows = $this->parseCsvFile($fullpath);

		// Create or update based on the rows
		foreach ($rows as $row) {
			$model = new $this->filemap[$table];
			$model->fill($row);
			$model->save();
		}

		// Output the results
		$this->info("Seeded $table with " . count($rows) . " rows");
	}

	/**
	 * Parse a CSV file into an array
	 *
	 * @param string $filepath
	 * @return array
	 */
	private function parseCsvFile(string $filepath): array {
		$rows = [];
		$handle = fopen($filepath, 'r');
		$header = fgetcsv($handle);

		while (($data = fgetcsv($handle)) !== false) {
			print_r($data);
			$row = [];
			foreach ($data as $key => $value) {
				$row[$header[$key]] = $value;
			}
			$rows[] = $row;
		}

		fclose($handle);

		return $rows;
	}
}
