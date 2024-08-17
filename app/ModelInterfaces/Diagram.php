<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Diagram
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Diagram extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		if (!isset($model)) {
			return [];
		}

		return [
			'id' => $model->id,
			'hash' => $model->hash,
			'diagram' => $model->diagram,
			'layout' => $model->layout,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
			'version' => (int) $model->version
		];
	}
}
