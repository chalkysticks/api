<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class TvChannel
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class TvChannel extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'youtube_id' => $model->youtube_id,
			'title' => $model->title,
			'description' => $model->description,
			'channel_id' => $model->channel_id,
			'image_url' => $model->image_url,
		];
	}
}
