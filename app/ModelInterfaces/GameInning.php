<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class GameInning
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class GameInning extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'shots_taken' => $model->shots_taken,
			'is_win' => $model->is_win,
			'is_loss' => $model->is_loss,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
			'ended_at' => (string) $model->ended_at,
		];
	}
}
