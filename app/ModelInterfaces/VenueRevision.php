<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class VenueRevision
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class VenueRevision extends ModelInterface {
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'user'
	];

	/**
	 * @param Models\Venue $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser($model) {
		if (!($user = $model->user)) {
			$user = new Models\User;
		}

		return $this->model($user, new User);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'venue_id' => $model->venue_id,
			'user_id' => $model->user_id,
			'data' => json_decode($model->data),
			'image_url' => $model->image_url
		];
	}
}
