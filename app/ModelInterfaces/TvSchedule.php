<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class TvSchedule
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class TvSchedule extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $availableIncludes = [];

	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'channel',
	];

	/**
	 * @param Models\TvSchedule $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeChannel(Models\TvSchedule $model) {
		return $model->channel ? $this->model($model->channel, new TvChannel) : null;
	}

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
