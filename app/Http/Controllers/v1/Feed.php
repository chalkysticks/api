<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\ModelInterfaces;
use App\Models;
use Carbon\Carbon;

/**
 * @class Feed
 * @package Http/Controllers/v1
 * @project ChalkySticks API
 */
class Feed extends Controller {
	/**
	 * @return \Illuminate\Http\Response
	 */
	public function getIndex() {
		$payload = (object) $this->payload([
			'lat' => ['required', 'numeric'],
			'lon' => ['required', 'numeric'],
			'd' => ['numeric'],
		], ['d' => 100]);

		// created at
		$created_at = new Carbon('now');

		// get a feed collection
		$collection = new Models\Feed;

		// optional distance filter
		$collection = $collection->where(function ($query) use ($payload) {
			return $query->distance($payload->d, $payload->lat . ',' . $payload->lon)
				->orWhere('lat', '=', 0);
		})
			->where('created_at', '<=', $created_at)
			->orderBy('created_at', 'desc');

		//
		$paginator = $collection->paginate($this->limit);

		return $this->paginate($paginator, new ModelInterfaces\Feed);
	}
}
