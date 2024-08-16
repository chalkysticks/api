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

	/**
	 * @var Models\Beacon
	 */
	public Models\Beacon $beacon;

	/**
	 * Create a new event instance.
	 *
	 * @param Models\Beacon $beacon
	 * @return void
	 */
	public function __construct(Models\Beacon $beacon) {
		$this->beacon = $beacon;
	}
}
