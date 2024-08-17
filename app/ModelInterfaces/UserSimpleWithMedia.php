<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class UserSimpleWithMedia
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserSimpleWithMedia extends ModelInterface {
	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'media',
	];

	/**
	 * @param Models\User $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeMedia(Models\User $model) {
		return $this->collection($model->media, new Media);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		if (!isset($model)) {
			return [];
		}

		return [
			'id' => (int) $model->id,
			'name' => (string) $model->name,
			'lat' => (double) $model->lat,
			'lon' => (double) $model->lon
		];
	}
}
