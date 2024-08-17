<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Team
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class TvSetting extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'key' => $model->key,
			'value' => $model->value,
		];
	}
}
