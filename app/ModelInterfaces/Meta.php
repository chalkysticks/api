<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Meta
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Meta extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'group' => $model->group,
			'key' => $model->key,
			'value' => $model->value,
		];
	}
}
