<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class VenueCheckin
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class VenueCheckin extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $availableIncludes = [
		'venue'
	];

	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'user'
	];

	/**
	 * @param Models\Venue $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeVenue($model) {
		return $this->model($model->venue, new Venue);
	}

	/**
	 * @param Models\Venue $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser($model) {
		return $this->model($model->user, new User);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [];
	}
}
