<?php

namespace App\Console\Commands\Beacon;

use App\Models;
use Carbon\Carbon;
use Config;
use Illuminate\Console\Command;

/**
 * @class Archive
 * @package Console/Commands/Beacon
 * @project ChalkySticks API
 */
class Archive extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'beacon:archive';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Takes old beacons and puts them into an archive table';

	/**
	 * Store beacons for 5 hours. We only use 3
	 * but in case we change our mind.
	 *
	 * @var int
	 */
	protected $archive_length = 120;

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$time = Carbon::now(Config::get('app.timezone'))
			->subHours($this->archive_length)
			->toDateTimeString();

		// Find Beacons less than a certain time
		$beacons = Models\Beacon::where('created_at', '<', $time)->get();

		// add beacon to archive, remove from live
		foreach ($beacons as $beacon) {
			Models\BeaconArchive::create([
				'user_id' => $beacon->user_id,
				'lat' => $beacon->lat,
				'lon' => $beacon->lon,
				'status' => $beacon->status,
				'keepalive' => $beacon->keepalive,
				'created_at' => $beacon->created_at,
				'updated_at' => $beacon->updated_at,
			]);

			$beacon->delete();
		}
	}
}
