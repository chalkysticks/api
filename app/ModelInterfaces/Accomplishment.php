<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Accomplishment
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Accomplishment extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'banner_url' => $model->banner_url,
			'description' => $model->description,
			'icon_url' => $model->icon_url,
		];
	}
}
