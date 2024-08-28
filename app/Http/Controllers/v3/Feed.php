<?php

namespace App\Http\Controllers\v3;

use App\Contracts;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedIndex;
use App\ModelInterfaces;
use App\Models;
use Carbon\Carbon;
use Illuminate\Http\Response;

/**
 * @class Feed
 * @package Http/Controllers/v3
 * @project ChalkySticks API
 */
class Feed extends Controller implements Contracts\Controller {
	/**
	 * @return Response
	 */
	public function getIndex(FeedIndex $request): Response {
		$payload = $request->validatedPayload();

		$collection = Models\Feed::withDistanceFilter($payload->d, $payload->lat, $payload->lon)
			->createdBefore(new Carbon('now'))
			->orderBy('created_at', 'desc');

		$paginator = $collection->paginate($this->limit);

		return $this->paginate($paginator, new ModelInterfaces\Feed);
	}
}
