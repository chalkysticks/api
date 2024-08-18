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
			'table_type' => $model->table_type,
			'ball_type' => $model->ball_type,
			'ball_count' => $model->ball_count,
			'is_complete' => $model->is_complete,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
			'version' => (int) $model->version
		];
	}
}
