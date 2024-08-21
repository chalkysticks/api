<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;
use Carbon\Carbon;

/**
 * @class Beacon
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Beacon extends ModelInterface {
	/**
	 * @var array
	 */
	protected array $defaultIncludes = [
		'user'
	];

	/**
	 * @param Models\Beacon $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser(Models\Beacon $model) {
		return $this->model($model->user, new User);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		$timeAgo = Carbon::createFromTimeStamp(strtotime($model->created_at))->diffForHumans();

		return [
			'id' => $model->id,
			'lat' => $model->lat,
			'lon' => $model->lon,
			'distance' => $model->distance,
			'time_ago' => $timeAgo,
			'status' => $model->status,
			'keepalive' => $model->keepalive,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at
		];
	}
}
