<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class UserPrize
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserPrize extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => (int) $model->id,
			'prize_id' => (int) $model->prize_id,
			'value' => (int) $model->value,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
		];
	}
}
