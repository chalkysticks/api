<?php

namespace App\Events;

use App\Models;
use Illuminate\Queue\SerializesModels;

/**
 * @class BeaconWasSent
 * @package Events
 * @project ChalkySticks API
 */
class BeaconWasSent extends Event {
	use SerializesModels;

	public $beacon;

	/**
	 * Create a new event instance.
	 *
	 * @param  Podcast  $beacon
	 * @return void
	 */
	public function __construct(Models\Beacons $beacon) {
		$this->beacon = $beacon;
	}

}
