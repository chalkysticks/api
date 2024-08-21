<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class TvChannelMap
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class TvChannelMap extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'youtube_channel_id' => $model->youtube_channel_id,
		];
	}
}
