<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Participant
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Participant extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'user'
	];

	/**
	 * @param  $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser($model) {
		return $this->model($model->user, new User);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'last_read' => (string) $model->last_read,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
		];
	}
}
