<?php

namespace App\Core\Data;

use DB;

/**
 * @class DistanceModel
 * @package Core/Data
 * @project ChalkySticks API
 */
trait DistanceModel {

	/**
	 * @var string[]
	 */
	protected $geofields = array('location');

	/**
	 * @param  \Illuminate\Database\Query\Builder  $query
	 * @param  int  $dist
	 * @param  string  $location
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function scopeDistance($query, int $dist, string $location) {
		// return $query
		//     ->addSelect(DB::raw('st_distance(POINT(lat, lon), POINT(' . $location . ')) as `distance`'))
		//     ->whereRaw('st_distance(POINT(lat, lon), POINT(' . $location . ')) < ' . $dist)
		//     ->orderBy('distance', 'ASC');
		return $query
			->addSelect(DB::raw('haversine_distance(lat, lon, ' . $location . ') as `distance`'))
			->whereRaw('haversine_distance(lat, lon, ' . $location . ') < ' . $dist);
	}

	/**
	 * @param mixed $query
	 * @return mixed
	 */
	public function scopeWeightedOrder($query) {
		$timeRatio = 60 * 3;

		return $query
			->from(DB::raw("(SELECT * FROM `$this->table` ORDER BY `created_at` DESC) as `$this->table`"))
			->orderByRaw("((1 - TIMESTAMPDIFF(MINUTE, `created_at`, now()) / $timeRatio) * 2 + (1 - `distance` / 3) * 3) DESC");
	}

	/**
	 * @param string $value
	 * @return void
	 */
	public function setLocationAttribute(string $value) {
		$this->attributes['location'] = DB::raw("POINT($value)");
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	public function getLocationAttribute($value) {

		$loc = substr($value, 6);
		$loc = preg_replace('/[ ,]+/', ',', $loc, 1);

		return substr($loc, 0, -1);
	}

	/**
	 * @param bool $excludeDeleted
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function newQuery(bool $excludeDeleted = true) {
		$raw = '';

		foreach ($this->geofields as $column) {
			$raw .= ' astext(' . $column . ') as ' . $column . ' ';
		}

		return parent::newQuery($excludeDeleted)
			->addSelect('*', DB::raw($raw));
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
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$lat,$lon&key=AIzaSyCKT38B_X04HKrtXC-f4ZETjQChApQwEqw";
		$response = json_decode(file_get_contents($url));

		// $response = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$lat,$lon"));
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
