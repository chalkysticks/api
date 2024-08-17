<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class GameNight
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class GameNight extends ModelInterface {
	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'matches'
	];

	/**
	 * @param Models\GameNight $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeMatches(Models\GameNight $model) {
		return $this->collection($model->matches, new GameMatch);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
		];
	}
}
