<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;

/**
 * @class TvSchedule
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class TvSchedule extends ModelInterface {
	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'title' => $model->title,
			'description' => $model->description,
			'duration' => $model->duration,
			'video_meta' => $model->video_meta,
			'embed_url' => $model->embed_url,
			'is_live' => $model->is_live,
			'air_at' => (string) $model->air_at,
			'created_at' => (string) $model->created_at,
		];
	}
}
