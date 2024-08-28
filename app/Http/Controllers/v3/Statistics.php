<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use App\Models;
use Illuminate\Http\Response;

/**
 * @class Statistics
 * @package Http/Controllers/v3
 * @project ChalkySticks API
 */
class Statistics extends Controller {
	/**
	 * Get the statistics summary.
	 *
	 * @return Response
	 */
	public function getIndex(): Response {
		$venueCount = $this->getVenueCount();
		$cityCount = $this->getCityCount();
		$beaconCount = $this->getBeaconCount();
		$userCount = $this->getUserCount();
		$videoDurations = $this->getVideoDurations();

		return $this->simpleResponse([
			'beacon_count' => $beaconCount,
			'city_count' => $cityCount,
			'venue_count' => $venueCount,
			'user_count' => $userCount,
			'video_duration_as_minutes' => $videoDurations['minutes'],
			'video_duration_as_hours' => $videoDurations['hours'],
		]);
	}

	/**
	 * Get the count of venues.
	 *
	 * @return int
	 */
	private function getVenueCount() {
		// Count venues with no related media and specific status
		$countQuery = Models\Venue::leftJoin('venuesmedia as vm', 'venues.id', '=', 'vm.venue_id')
			->whereNull('vm.id')
			->where('venues.status', 130)
			->count();

		// Count the number of unique venue_ids in the venuesmedia table
		$venueMediaCount = Models\VenueMedia::groupBy('venue_id')->count();

		return $venueMediaCount + $countQuery;

	}

	/**
	 * Get the count of cities with venues.
	 *
	 * @return int
	 */
	private function getCityCount() {
		return Models\Venue::where('status', '>=', 101)->groupBy('city')->count();
	}

	/**
	 * Get the count of beacons (including archived).
	 *
	 * @return int
	 */
	private function getBeaconCount() {
		$beaconCount = Models\Beacon::count();
		$beaconArchiveCount = Models\BeaconArchive::count();

		return $beaconCount + $beaconArchiveCount;
	}

	/**
	 * Get the count of users.
	 *
	 * @return int
	 */
	private function getUserCount() {
		return Models\User::count();
	}

	/**
	 * Get the video durations in different time units.
	 *
	 * @return array
	 */
	private function getVideoDurations() {
		$durationQuery = Models\TvSchedule::where('flags', 0)
			->whereNull('is_live')
			->selectRaw('
                SUM(duration) as duration,
                ROUND(SUM(duration) / 60) as duration_as_minutes,
                ROUND(SUM(duration) / 60 / 60) as duration_as_hours,
                ROUND(SUM(duration) / 60 / 60 / 24) as duration_as_days
            ')
			->first();

		return [
			'seconds' => $durationQuery->duration,
			'minutes' => $durationQuery->duration_as_minutes,
			'hours' => $durationQuery->duration_as_hours,
			'days' => $durationQuery->duration_as_days,
		];
	}
}
