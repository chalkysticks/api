<?php

namespace App\Core\Data;

use DB;
use Illuminate\Database;

/**
 * @class DistanceModel
 * @package Core/Data
 * @project ChalkySticks API
 */
trait DistanceModel {
	/**
	 * @var string[]
	 */
	protected $geofields = ['location'];

	// /**
	//  * @param  Database\Query\Builder  $query
	//  * @param  int  $dist
	//  * @param  string  $location
	//  * @return Database\Query\Builder
	//  */
	// public function scopeDistance($query, int $dist, string $location) {
	// 	// return $query
	// 	//     ->addSelect(DB::raw('st_distance(POINT(lat, lon), POINT(' . $location . ')) as `distance`'))
	// 	//     ->whereRaw('st_distance(POINT(lat, lon), POINT(' . $location . ')) < ' . $dist)
	// 	//     ->orderBy('distance', 'ASC');

	// 	return $query
	// 		->addSelect(DB::raw('haversine_distance(lat, lon, ' . $location . ') as `distance`'))
	// 		->whereRaw('haversine_distance(lat, lon, ' . $location . ') < ' . $dist);
	// }

	// /**
	//  * @param string $value
	//  * @return void
	//  */
	// public function setLocationAttribute(string $value) {
	// 	$this->attributes['location'] = DB::raw("POINT($value)");
	// }

	// /**
	//  * @param mixed $value
	//  * @return string
	//  */
	// public function getLocationAttribute($value) {

	// 	$loc = substr($value, 6);
	// 	$loc = preg_replace('/[ ,]+/', ',', $loc, 1);

	// 	return substr($loc, 0, -1);
	// }

	// /**
	//  * @param bool $excludeDeleted
	//  * @return Database\Eloquent\Builder
	//  */
	// public function newQuery(bool $excludeDeleted = true) {
	// 	$raw = '';

	// 	foreach ($this->geofields as $column) {
	// 		$raw .= ' astext(' . $column . ') as ' . $column . ' ';
	// 	}

	// 	return parent::newQuery($excludeDeleted)
	// 		->addSelect('*', DB::raw($raw));
	// }

	/**
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @param  int  $dist
	 * @param  string  $location
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeDistance(\Illuminate\Database\Eloquent\Builder $query, int $dist, string $location) {
		// Assuming $location is in "lat,lon" format
		list($lat, $lon) = explode(',', $location);

		// Haversine formula in SQLite
		$haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(lon) - radians($lon)) + sin(radians($lat)) * sin(radians(lat))))";

		return $query
			->addSelect(DB::raw("$haversine as distance"))
			->whereRaw("$haversine < ?", [$dist])
			->orderBy('distance', 'ASC');
	}

	/**
	 * @param mixed $query
	 * @return mixed
	 */
	public function scopeWeightedOrder($query) {
		$timeRatio = 60 * 3;

		return $query
			->from(DB::raw("(SELECT * FROM `$this->table` ORDER BY `created_at` DESC) as `$this->table`"))
			->orderByRaw("((1 - (strftime('%s','now') - strftime('%s', `created_at`)) / $timeRatio) * 2 + (1 - `distance` / 3) * 3) DESC");
	}

	/**
	 * Store point as "lat,lon" for SQLite compatibility
	 *
	 * @param string $value
	 * @return void
	 */
	public function setLocationAttribute(string $value) {
		$this->attributes['location'] = $value;
	}

	/**
	 * Assumes location stored as "lat,lon"
	 *
	 * @param mixed $value
	 * @return string
	 */
	public function getLocationAttribute($value) {
		return $value;
	}

	/**
	 * @return Database\Eloquent\Builder
	 */
	public function newQuery() {
		return parent::newQuery()->addSelect('*');
	}

	/**
	 * @param float $lat
	 * @param float $lon
	 * @return mixed
	 */
	public function coordinatesToLocation($lat = null, $lon = null) {
		if (!$lat && !$lon) {
			$lat = $this->latitude;
			$lon = $this->longitude;
		}

		// get lat long from google
		$api_key = config('google.map.api_key');
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$lat,$lon&key=$api_key";
		$response = json_decode(file_get_contents($url));
		$address = array();

		if ($response->status == 'OK') {
			foreach ($response->results[0]->address_components as $comp) {
				$address[$comp->types[0]] = $comp->short_name;
			}

			return (object) $address;
		}

		return false;
	}
}
