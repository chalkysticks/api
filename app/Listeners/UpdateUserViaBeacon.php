<?php

namespace App\Listeners;

use App\Events;
use App\Models;

/**
 * @class UpdateUserViaBeacon
 * @package Listeners
 * @project ChalkySticks API
 */
class UpdateUserViaBeacon {
	/**
	 * @param  Events\BeaconWasSent  $event
	 * @return void
	 */
	public function handle(Events\BeaconWasSent $event) {
		$user = Models\User::find($event->beacon->user_id);

		// update position
		$user->lat = $event->beacon->lat;
		$user->lon = $event->beacon->lon;

		// update last location
		if ($address = $event->beacon->coordinatesToLocation($event->beacon->lat, $event->beacon->lon)) {
			$user->addProfileMeta('last_location', $address->locality . ', ' . $address->administrative_area_level_1);
		}

		// update how many beacons have been sent
		$user->meta->increment($user->id, 'profile', 'beacons_sent');

		// save
		$user->save();
	}
}
