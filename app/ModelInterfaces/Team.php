<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class Team
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Team extends ModelInterface {
	/**
	 * @param Models\Team $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeOwner(Models\Team $model) {
		$owner = $model->owner;

		return $this->collection($owner, new User);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'name' => $model->name,
			'league_type' => $model->league_type,
			'league_id' => $model->league_id,
			'rank' => $model->rank,
			'wins' => $model->wins,
			'losses' => $model->losses,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
		];
	}
}
