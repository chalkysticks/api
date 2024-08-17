<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class UserSimple
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class UserSimple extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => (int) $model->id,
			'name' => (string) $model->name,
			'phone' => (string) $model->phone,
			'lat' => (double) $model->lat,
			'lon' => (double) $model->lon
		];
	}
}
