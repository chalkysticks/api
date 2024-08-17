<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Ad
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Ad extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'caption' => $model->caption,
			'company' => $model->company,
			'image' => $model->image,
			'url' => $model->url
		];
	}
}
