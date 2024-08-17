<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Tag
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Tag extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'tag' => $model->tag
		];
	}
}
