<?php

namespace App\ModelInterfaces;

use App\Core\Data\ModelInterface;
use App\Models;

/**
 * @class Game
 * @package ModelInterfaces
 * @project ChalkySticks API
 */
class Game extends ModelInterface {
	/**
	 * @var array
	 */
	protected $availableIncludes = [
		'innings'
	];

	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'user1',
		'user2'
	];

	/**
	 * @param Models\Game $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser1(Models\Game $model) {
		return $this->model($model->user1, new User);
	}

	/**
	 * @param Models\Game $model
	 * @return \League\Fractal\Resource\Item
	 */
	public function includeUser2(Models\Game $model) {
		return $this->model($model->user2, new User);
	}

	/**
	 * @param Models\Game $model
	 * @return \League\Fractal\Resource\Collection
	 */
	public function includeInnings(Models\Game $model) {
		return $this->collection($model->innings, new GameInning);
	}

	/**
	 * @return array
	 */
	public function transform($model) {
		return [
			'id' => $model->id,
			'is_win' => $model->is_win,
			'is_loss' => $model->is_loss,
			'created_at' => (string) $model->created_at,
			'updated_at' => (string) $model->updated_at,
			'ended_at' => (string) $model->ended_at,
		];
	}
}
