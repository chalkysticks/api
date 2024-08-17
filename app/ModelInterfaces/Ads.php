<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class Ads
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Ads extends ModelInterface {
	/**
	 * Turn this item object into a generic array
	 *
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
